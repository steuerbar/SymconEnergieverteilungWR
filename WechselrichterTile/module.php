<?php

declare(strict_types=1);

class FroniusEnergieflussKachel extends IPSModule
{
    private const VARIABLES = [
        'PVPowerID',
        'PVEnergyID',
        'BatterySocID',
        'BatteryPowerID',
        'GridPowerID',
        'HouseLoadID'
    ];

    public function Create()
    {
        parent::Create();
        foreach (self::VARIABLES as $property) {
            $this->RegisterPropertyInteger($property, 0);
        }
        $this->RegisterPropertyFloat('PVPowerFactor', 1.0);
        $this->RegisterPropertyFloat('BatteryPowerFactor', 1.0);
        $this->RegisterPropertyFloat('GridPowerFactor', 0.001);
        $this->RegisterPropertyFloat('HouseLoadFactor', 0.001);
        $this->RegisterAttributeString('SubscribedVariables', '[]');
        $this->SetVisualizationType(1);
    }

    public function ApplyChanges()
    {
        parent::ApplyChanges();
        $oldIDs = json_decode($this->ReadAttributeString('SubscribedVariables'), true);
        if (is_array($oldIDs)) {
            foreach ($oldIDs as $id) {
                if (is_int($id) && $id > 0 && IPS_ObjectExists($id)) {
                    $this->UnregisterMessage($id, VM_UPDATE);
                }
            }
        }

        $newIDs = [];
        foreach (self::VARIABLES as $property) {
            $id = $this->ReadPropertyInteger($property);
            if (IPS_VariableExists($id)) {
                $this->RegisterMessage($id, VM_UPDATE);
                $newIDs[] = $id;
            }
        }
        $this->WriteAttributeString('SubscribedVariables', json_encode($newIDs));
        $this->SetStatus(count($newIDs) === count(self::VARIABLES) ? 102 : 201);
        $this->UpdateTile();
    }

    public function MessageSink($timeStamp, $senderID, $message, $data)
    {
        parent::MessageSink($timeStamp, $senderID, $message, $data);
        if ($message === VM_UPDATE) {
            $this->UpdateTile();
        }
    }

    public function GetVisualizationTile()
    {
        $html = file_get_contents(__DIR__ . '/module.html');
        $html = str_replace('__INITIAL_STATE__', $this->StateJSON(), $html);
        $html = str_replace('__INVERTER_IMAGE__', $this->ImageData('inverter.png'), $html);
        $html = str_replace('__BATTERY_IMAGE__', $this->ImageData('battery.png'), $html);
        return str_replace('__METER_IMAGE__', $this->ImageData('meter.png'), $html);
    }

    public function UpdateTile()
    {
        $this->UpdateVisualizationValue($this->StateJSON());
    }

    private function GetState(): array
    {
        $pv = max(0.0, $this->Numeric('PVPowerID') * $this->ReadPropertyFloat('PVPowerFactor'));
        $energy = max(0.0, $this->Numeric('PVEnergyID'));
        $soc = max(0.0, min(100.0, $this->Numeric('BatterySocID')));
        $battery = $this->Numeric('BatteryPowerID') * $this->ReadPropertyFloat('BatteryPowerFactor');
        $grid = $this->Numeric('GridPowerID') * $this->ReadPropertyFloat('GridPowerFactor');
        $house = max(0.0, $this->Numeric('HouseLoadID') * $this->ReadPropertyFloat('HouseLoadFactor'));

        return [
            'valid'         => $this->AllVariablesValid(),
            'pvPower'       => round($pv, 2),
            'pvEnergy'      => round($energy, 1),
            'batterySoc'    => round($soc, 1),
            'batteryPower'  => round(abs($battery), 2),
            'batteryMode'   => abs($battery) < 0.03 ? 'idle' : ($battery < 0 ? 'discharge' : 'charge'),
            'gridPower'     => round(abs($grid), 2),
            'gridMode'      => abs($grid) < 0.03 ? 'idle' : ($grid > 0 ? 'import' : 'export'),
            'houseLoad'     => round($house, 2),
            'updated'       => time()
        ];
    }

    private function Numeric(string $property): float
    {
        $id = $this->ReadPropertyInteger($property);
        return IPS_VariableExists($id) && is_numeric(GetValue($id)) ? (float) GetValue($id) : 0.0;
    }

    private function AllVariablesValid(): bool
    {
        foreach (self::VARIABLES as $property) {
            if (!IPS_VariableExists($this->ReadPropertyInteger($property))) {
                return false;
            }
        }
        return true;
    }

    private function ImageData(string $name): string
    {
        $data = file_get_contents(__DIR__ . '/assets/' . $name);
        return 'data:image/png;base64,' . base64_encode($data);
    }

    private function StateJSON(): string
    {
        return (string) json_encode(
            $this->GetState(),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
        );
    }
}

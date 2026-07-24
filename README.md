# GEN24 Energieverteilung

Native Symcon-Kachel für einen Fronius-GEN24-Wechselrichter, einen
BYD-Speicher und ein Smart Meter.

Die Bibliothek enthält genau einen Instanztyp: `GEN24 Energieverteilung`.
Die Kachel verwendet ausschließlich bereits vorhandene Messvariablen und
legt keine parallelen Energie- oder Leistungswerte an.

## Darstellung

- PV, GEN24, Netz, Haus und BYD als klare Symbole
- getrennte, farbige und richtungsabhängige Energieflüsse
- Ladezustand und Lade-/Entladeleistung des Speichers
- Netzbezug beziehungsweise Einspeisung
- aktueller Hausverbrauch

Die Topologie entspricht dem hybriden GEN24-Aufbau: Der BYD-Speicher ist
direkt an der DC-Seite des Wechselrichters angeschlossen. Erst der
Wechselrichter speist den AC-Hausbus. Das Smart Meter verbindet den
Hausbus bidirektional mit dem Netz.

## Messwerte

Die tatsächliche Leistung der PV-Module wird aus der Summe der beiden
DC-Tracker `V_MPPT1_DC_Power` und `V_MPPT2_DC_Power` gebildet. Die
AC-Ausgangsleistung des Wechselrichters darf hierfür nicht verwendet
werden, da sie auch Leistung aus dem Batteriespeicher enthalten kann.

Für jede Leistungsquelle kann ein Faktor eingestellt werden. Ein Wert in
Watt wird mit `0,001`, ein Wert in Kilowatt mit `1` multipliziert.

Konfiguration des Testsystems:

| Funktion | Objekt-ID | Einheit/Faktor |
|---|---:|---:|
| PV DC-Leistung MPPT 1 | `44428` | kW / `1` |
| PV DC-Leistung MPPT 2 | `17169` | kW / `1` |
| BYD-Ladezustand | `18125` | % |
| BYD Lade-/Entladeleistung | `13731` | kW / `1` |
| Smart-Meter-Netzleistung | `30359` | W / `0,001` |
| Hausverbrauch | `57223` | W / `0,001` |

## Änderung in Version 1.4

Die frühere bildbasierte Vergleichskachel und sämtliche Aliasnamen wurden
entfernt. In der Symcon-Instanzverwaltung erscheint unter dem Hersteller
`steuerbar` nur noch `GEN24 Energieverteilung`.

Build 6 gleicht den PHP-Klassennamen an den neuen Modulnamen an.

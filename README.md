# Fronius Energiefluss

Native Symcon-Kachel für einen Fronius-GEN24-Wechselrichter, einen
BYD-Speicher und ein Smart Meter.

Die Kachel verwendet ausschließlich bereits vorhandene Messvariablen. Sie
legt keine parallelen Energie- oder Leistungswerte an.

## Darstellung

- Fronius-Wechselrichter mit aktueller AC-Leistung und Gesamtertrag
- BYD-Speicherturm mit Ladezustand und Lade-/Entladeleistung
- Smart Meter mit Netzbezug beziehungsweise Einspeisung
- Hausverbrauch als zentrale Zusatzinformation
- dezente, richtungsabhängige Energieflussanimation

Die Topologie entspricht dem hybriden GEN24-Aufbau: Der BYD-Speicher ist
direkt an der DC-Seite des Wechselrichters angeschlossen. Erst der
Wechselrichter speist den AC-Hausbus. Das Smart Meter verbindet den
Hausbus bidirektional mit dem Netz.

Die Geräteillustrationen wurden speziell für diese Kachel erzeugt und
liegen freigestellt im Modulordner `WechselrichterTile/assets`.

## Einheiten

Für jede Leistungsquelle kann ein Faktor eingestellt werden. Ein Wert in
Watt wird mit `0,001`, ein Wert in Kilowatt mit `1` multipliziert.

## Installation auf dem Energie-System

Testsystem: `10.14.39.167`

- Instanz: `Fronius Energiefluss` (`48490`)
- Ablage: `Energieerzeugung / PV-Anlage`
- lokale, read-only Modulquelle:
  `git://10.14.39.167/wechselrichter.git`
- Module-Control-Kennung: `wechselrichter`

Verknüpfte Bestandsvariablen:

| Funktion | Objekt-ID | Einheit/Faktor |
|---|---:|---:|
| Fronius AC-Leistung | `32490` | kW / `1` |
| Fronius Gesamtertrag | `56056` | kWh |
| BYD-Ladezustand | `18125` | % |
| BYD Lade-/Entladeleistung | `13731` | kW / `1` |
| Smart-Meter-Netzleistung | `30359` | W / `0,001` |
| Hausverbrauch | `57223` | W / `0,001` |

Die lokale Modulquelle wird ausschließlich für den Testbetrieb verwendet.
Für eine Verteilung auf weitere Systeme wird die Bibliothek später in ein
GitHub-Repository übernommen.

## Zweite Darstellungsvariante

Ab Version 1.1 enthält die Bibliothek zusätzlich die Instanz
`Energiefluss Symbol Kachel`. Sie verzichtet vollständig auf Gerätebilder
und stellt PV, GEN24, Smart Meter/Netz, Haus und BYD als klare Symbole dar.
Jeder Energiestrang besitzt eine eigene Farbe und Animation.

Die erste bildbasierte `Fronius Energiefluss Kachel` bleibt unverändert
erhalten, sodass beide Entwürfe parallel verglichen werden können.

Ab Version 1.2 ermittelt die Symbolkachel die tatsächliche Leistung der
PV-Module aus der Summe der beiden DC-Tracker `V_MPPT1_DC_Power` und
`V_MPPT2_DC_Power`. Die AC-Ausgangsleistung des Wechselrichters ist hierfür
nicht geeignet, da sie bei Nacht auch die aus dem Speicher bereitgestellte
Leistung enthält. Der Gesamtertrag wird im PV-Kreis nicht mehr angezeigt.

Konfiguration der Symbolkachel auf dem Testsystem:

| Funktion | Objekt-ID | Einheit/Faktor |
|---|---:|---:|
| PV DC-Leistung MPPT 1 | `44428` | kW / `1` |
| PV DC-Leistung MPPT 2 | `17169` | kW / `1` |
| BYD-Ladezustand | `18125` | % |
| BYD Lade-/Entladeleistung | `13731` | kW / `1` |
| Smart-Meter-Netzleistung | `30359` | W / `0,001` |
| Hausverbrauch | `57223` | W / `0,001` |

Ab Version 1.3 trägt der Netzknoten in der Kachel die kompakte
Beschriftung `Netz`.

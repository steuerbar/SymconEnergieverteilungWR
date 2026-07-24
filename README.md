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

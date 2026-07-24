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


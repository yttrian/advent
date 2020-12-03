#!/usr/bin/env wolframscript

modules := ReadList["input.txt", Number]
MassCost[item_] := Floor[item / 3] - 2
FuelCost[fuel_] := fuel + 1
cost := FuelCost[MassCost[modules]]
result := Total[cost]

Print[result]
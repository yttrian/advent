#!/usr/bin/env wolframscript

modules := ReadList["input.txt", Number]
fuel := Floor[modules / 3] - 2
result := Total[fuel]

Print[result]
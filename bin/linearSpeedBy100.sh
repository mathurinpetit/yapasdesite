#!/bin/bash
echo "" > ./data/CRON
ffmpeg -i $1 -filter:v "setpts=0.01*PTS" -an $2

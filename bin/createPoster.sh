#!/bin/bash

MaxFrames="100"
seuil=160

cd $1"/imagesList"

# Calculate how many images we have
N=$(ls image*.png|wc -l)
echo "New nb images N:"$N

z="0"$(bc <<< 'scale=4; 1/'$N)
echo "Transparency percent : "$z



# Generate mask, start with black and add in components from each subsequent image
i=0
mkdir transparent

for f in image*png;do
   convert "$f" -alpha set -background none -channel A -evaluate multiply $z +channel transparent/"$f"
done

cd transparent
# Generate output image
convert image*.png -flatten out.png

cp out.png ../../$2"_poster.png"

cd ../..
convert $2"_poster.png" -flatten $2_poster_pre.png
convert $2"_poster.png" -contrast -contrast -contrast -contrast $2"_poster_contast.png"

convert $2_poster_pre.png -modulate 100,200 -level 25% $2_poster_re.png
convert $2_poster_re.png -modulate 300 $2_poster_fin.png


rm -rf imagesList/transparent
#rm -rf imagesList

#!/bin/bash

MaxFrames="100"
seuil=160

# Duration
DURATION=$(ffmpeg -i $1 2>&1 | grep "Duration"| cut -d ' ' -f 4 | sed s/,// | sed 's@\..*@@g' | awk '{ split($1, A, ":"); split(A[3], B, "."); print 3600*A[1] + 60*A[2] + B[1] }')


echo "Duration = "$DURATION" seconds"
fps="0"$(bc <<< 'scale=4; '$MaxFrames'/'$DURATION)
echo "Fps = "$fps


rm -rf $2"/imagesList"
mkdir $2"/imagesList"
ffmpeg -i $1 -r $fps $2"/imagesList"/image%04d.png

cd $2"/imagesList"



# Calculate how many images we have
N=$(ls image*.png|wc -l)
echo "First nb images N:"$N

#cleaning black frames

for f in image*png;do
   convert "$f" -resize 1x1  1pixel"$f".jpeg
   convert 1pixel"$f".jpeg 1pixel"$f".txt
   color=$(cat 1pixel"$f".txt | grep -v '# I' |sed -r 's|(.+)\ \(([0-9]+),([0-9]+),([0-9]+)\) .+|\2+\3+\4|g' | bc)
   if (( $color < $seuil )); then
     echo "Image $f trop sombre : sum=$color => remove"
     rm "$f";
   fi
done

rm 1pixel*

mkdir withoutBlack
#remove black
for f in image*png;do
   convert "$f" -alpha set  -channel RGBA -fill none -opaque black withoutBlack/"$f"
done

rm image*png;
cp withoutBlack/image*png .
rm -rf withoutBlack

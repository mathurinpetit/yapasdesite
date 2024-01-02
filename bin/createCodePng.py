import sys
import os
import subprocess
from PIL import Image, ImageDraw, ImageFont
import cv2
import numpy as np

framify_path_project='~/framify';

def framify(video_path, directoryForMovie , radixOfMovieName, text):

    nameOfCodePng = radixOfMovieName+'_code.png'
    nameOfCodeSquarePng = radixOfMovieName+'_code_square.png'
    nameOfCodeSvg = radixOfMovieName+'_code.svg'

    ### FRAMIFY MOVIE #

    movieToFramify=video_path;

    createFramifyCodePng="cp "+movieToFramify+" "+framify_path_project+"/"+radixOfMovieName+".mp4; cd "+framify_path_project+"; ./framify.sh "+radixOfMovieName+".mp4";

    print(createFramifyCodePng);
    os.system(createFramifyCodePng);

    pngPath = directoryForMovie+'/'+nameOfCodePng;
    moveFramifyCodePngSvg="mv "+framify_path_project+'/'+radixOfMovieName+".png "+pngPath+"; mv "+framify_path_project+'/'+radixOfMovieName+".svg "+directoryForMovie+'/'+nameOfCodeSvg;
    os.system(moveFramifyCodePngSvg);

    cleanFramify="cd "+framify_path_project+'; rm '+radixOfMovieName+".mp4; rm -rf "+radixOfMovieName;
    os.system(cleanFramify);

    codePng = Image.open(pngPath);

    pngTmpSquarePath = directoryForMovie+'/'+radixOfMovieName+"_tmp.png";
    codePngresized = codePng.resize((4096, 1024));
    codePngresized.save(pngTmpSquarePath);

    imgTmp = cv2.imread(pngTmpSquarePath);

    height, width, channels = imgTmp.shape
    half_width = width//2

    top_section = imgTmp[:, :half_width]
    bottom_section = imgTmp[:, half_width:]

    cv2.imwrite(directoryForMovie+"/tileUp.png", top_section);
    cv2.imwrite(directoryForMovie+"/tileDown.png", bottom_section);

    tileUp = Image.open(directoryForMovie+"/tileUp.png");
    tileDown = Image.open(directoryForMovie+"/tileDown.png");

    def get_concat_v(im1, im2):
        dst = Image.new('RGB', (im1.width, im1.height + im2.height))
        dst.paste(im1, (0, 0))
        dst.paste(im2, (0, im1.height))
        return dst

    composedCode = get_concat_v(tileUp, tileDown);
    fnt = ImageFont.truetype("/usr/share/fonts/truetype/freefont/FreeSerifBold.ttf", 80, encoding="unic")

    d = ImageDraw.Draw(composedCode)
    d.text((100,100), text, font=fnt, fill=(255,255,255));

    composedCode.save(directoryForMovie+'/'+nameOfCodeSquarePng)

    os.remove(directoryForMovie+"/tileUp.png")
    os.remove(directoryForMovie+"/tileDown.png")
    os.remove(pngTmpSquarePath)

import sys
import os
import subprocess
from createCodePng import *

#parameters
dataFolder="./data/";
#end of parameters

movie_path=sys.argv[1];
if not os.path.isfile(movie_path):
    print("Le fichier n'existe pas !");
    exit(1);

print("Fichier à traiter : "+movie_path);

nameOfMovie=sys.argv[2];
directorOfMovie=sys.argv[3];
yearOfMovie=sys.argv[4];

if not nameOfMovie or not directorOfMovie or not yearOfMovie:
    print("Les arguments sont manquants");
    exit(1);

print("Film : ");
print(nameOfMovie+'');
print(directorOfMovie+'');
print(yearOfMovie+'\n');

#### Nom des fichiers/dossiers ####*
radixOfMovieName = os.path.splitext(nameOfMovie.replace(" ", ""))[0];
directoryForMovie=dataFolder+radixOfMovieName;
os.makedirs(directoryForMovie,exist_ok=True);

nameOfMovieSpeedBy100 = radixOfMovieName+'x100.mp4 ';
nameOfCodePng = radixOfMovieName+'_code.png'
nameOfCodeSquarePng = radixOfMovieName+'_code_square.png'
nameOfCodeSvg = radixOfMovieName+'_code.svg'

print("Dossier : "+directoryForMovie);
print("     - Fichier "+directoryForMovie+'/'+radixOfMovieName);
print("     - Fichier "+directoryForMovie+'/'+nameOfMovieSpeedBy100);
print("     - Fichier "+directoryForMovie+'/'+radixOfMovieName+'x100_timecoded.mp4 ');
print("     - Fichiers "+directoryForMovie+'/'+nameOfCodePng+' (2048x2048) ');
print("     - Fichiers "+directoryForMovie+'/colors/'+radixOfMovieName+'_seq_n.jpg (1024x1024) to select in web ');



createLinearSpeedBy100="pwd; ./bin/linearSpeedBy100.sh "+movie_path+" "+directoryForMovie+'/'+nameOfMovieSpeedBy100;
print(createLinearSpeedBy100);
#STEP 1 : createLinearSpeedBy100
subprocess.run(createLinearSpeedBy100, shell = True, executable="/bin/bash")

#STEP 2 : FRAMIFY
framify(movie_path, directoryForMovie, radixOfMovieName, nameOfMovie+'\n\n'+directorOfMovie+'\n\n'+yearOfMovie);

#STEP 3 : LIST OF FRAMES
extractColoredFrames ="./bin/extractColoredFrames.sh "+directoryForMovie+'/'+nameOfMovieSpeedBy100+" "+directoryForMovie
subprocess.run(extractColoredFrames, shell = True, executable="/bin/bash")

#STEP 4 : CREATE POSTER
# createPoster ="bin/createPoster.sh "+directoryForMovie+" "+radixOfMovieName
# subprocess.run(createPoster, shell = True, executable="/bin/bash")

print("2nd appel de script => fichiers deja selectionné et image poster resultante");


#os.rmdir(directoryForMovie);

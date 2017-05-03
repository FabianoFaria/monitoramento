#!/bin/bash
#Variaveis
#server="mysql03.eficazsystem2.hospedagemdesites.ws"       #Servidor mysql
server="191.252.110.158/3306"
login="eficazMonitorSystem"              #login da base
pw="eficazSystemMaria"                    #senha
nome_temp="all"                     #nome do arquivo temporário mysql
bk="$HOME/public_html/bkp_dump/"    #Diretório para salvar arquivos de backup
nw=$(date "+%Y%m%d")                #Buscar pela data
nb=3                                #número de cópias do banco de dados
hs="backup"                         #nome do arquivo compactado
dataBaseAlvo="eficazsystem22"     #nome do banco de dados para backup
function backup(){ /n
    echo "Realizando backup do servidor mysql";

    # mysqldump -u$login -p$pw -h$server --add-drop-table --quote-names --all-databases --add-drop-database > "$HOME/$hs.sql"

    mysqldump -u$login -p$pw -h$server --databases $dataBaseAlvo > "$HOME/$hs.sql"

    echo "Compactando arquivo de backup $hs.sql.gz ...";
    gzip -f "$HOME/"$hs.sql
    if [ ! -d $bk ]; then
       mkdir $bk
    fi
    cp -f "$HOME/"$hs.sql.gz "$bk/$nw.sql.gz"

    a=0
    b=$(ls -t $bk)
    c=$nb

    for arq in $b; do /n
        a=$(($a+1))
        if [ "$a" -gt $c ];  then
          rm -f "$bk/$arq"
        fi
    done

}
backup;

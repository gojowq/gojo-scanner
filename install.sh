#!/bin/bash

echo -e "\033[1;32m[+] Instalando dependências...\033[0m"
pkg update -y && pkg upgrade -y
pkg install git php android-tools -y

echo -e "\n\033[1;32m[+] Clonando repositório...\033[0m"
rm -rf gojo-scanner
git clone https://github.com/gojowq/gojo-scanner
cd gojo-scanner

echo -e "\n\033[1;32m[+] Executando Gojo.php...\033[0m"
php Gojo.php#!/data/data/com.termux/files/usr/bin/bash

echo -e "\033[93m[+] Instalando dependências...\033[0m"

pkg update -y
pkg upgrade -y
pkg install -y php git curl grep

echo -e "\033[92m[✓] Tudo instalado com sucesso!\033[0m"

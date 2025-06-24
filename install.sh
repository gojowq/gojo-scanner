#!/data/data/com.termux/files/usr/bin/bash

echo -e "\033[93m[+] Instalando dependências...\033[0m"

pkg update -y
pkg upgrade -y
pkg install -y php git curl grep

echo -e "\033[92m[✓] Tudo instalado com sucesso!\033[0m"

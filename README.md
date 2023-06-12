# food-order
CONFIGURANDO MAQUINA VIRTUAL UBUNTO NO GCP

1.	Depois de criada conectar ao ssh e entrar no terminal Ubuntu.

2.	Atualizar o Ubunto com o seguinte comando: sudo apt-get update.


3.	Depois devemos executar o comando de atualização: sudo apt-get upgrade -y.

4.	Use o comando a seguir para limpar o terminal: clear.


5.	Baixe o instalador do do xampp utilizando o seguinte comando: wget + o link da versão lts do xampp que você deseja. Por exemplo: wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.0.28/xampp-linux-x64-8.0.28-0-installer.run

6.	Renomeie o arquivo do xampp para um nome mais adequado utilizando: mv + nome do download + novo nome por exemplo: xampp-installer.run.


7.	Dê permissão para a execução do arquivo de instalação do xampp com o seguinte comando: chmod +x xampp-installer.run.

8.	Depois execute o instalador do xampp com o seguinte comando: sudo ./xampp-installer.run.


9.	 Antes de iniciar o servidor apache você deve instalar os pacotes net-tools. Para isso execute o seguinte comando: sudo apt-get install net-tools.

10.	 Verifique se o utilitário 'netstat' está localizado no caminho correto. Execute o seguinte comando para verificar: which netstat.


11.	Caso apareca erros por não tem permissão para acessar ou gravar arquivos de sessão no diretório /opt/lampp/temp/. Vamos ajustar as permissões para corrigir o problema.Execute os seguintes comandos no terminal para corrigir as permissões do diretório de sessões: sudo chown -R daemon:daemon /opt/lampp/temp/  e depois sudo chmod -R 777 /opt/lampp/temp/. Esses comandos alteram o proprietário e as permissões do diretório /opt/lampp/temp/ para permitir que o PHP acesse e grave arquivos de sessão corretamente.


Obs!!!!!!!!
	Se você deseja acessar o XAMPP de uma rede externa, você precisará fazer algumas alterações na configuração. Aqui estão os passos para permitir o acesso remoto ao XAMPP:
    Abra o arquivo de configuração "httpd-xampp.conf" localizado no diretório "/opt/lampp/etc/extra". Você pode usar o comando:
sudo nano /opt/lampp/etc/extra/httpd-xampp.conf 

Dentro do arquivo, procure a seção que contém as diretivas de restrição de acesso:
  <Directory "/opt/lampp/phpmyadmin">
    AllowOverride AuthConfig Limit
    Order allow,deny
    Allow from all
    Require all granted
  </Directory>

Altere a diretiva "Require all granted" para permitir o acesso de qualquer endereço IP. Substitua por:
Require all granted

Salve o arquivo e saia do editor de texto.
Reinicie o XAMPP executando o comando:
sudo /opt/lampp/lampp restart
Após seguir esses passos, você deverá ser capaz de acessar o XAMPP de uma rede externa digitando o endereço IP da sua máquina virtual GCP no navegador.

1.	Depois disso deve aparecer um erro na conexão do mySql. Para corrigir isso, vamos ajustar as permissões do diretório /opt/lampp/var/mysql/ e garantir que o usuário correto tenha acesso de escrita. Execute os seguintes comandos no terminal: sudo chown -R mysql:mysql /opt/lampp/var/mysql/ e depois sudo chmod -R 755 /opt/lampp/var/mysql/. Esses comandos alteram o proprietário e as permissões do diretório /opt/lampp/var/mysql/ para que o MySQL possa criar e gravar arquivos de log.



Após a conclusão da instalação, você pode iniciar o servidor Apache e o servidor MySQL executando o seguinte comando: sudo /opt/lampp/lampp start












## DER DO BANCO DE DADOS


![Imagem do DER atualizada](https://github.com/Glemnt/food-order/assets/99224638/0e6d1e8f-9498-49ae-a57f-df21b7717c77)














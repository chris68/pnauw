#!/bin/bash
env=""
while getopts "e:" optname
  do
    case "$optname" in
      "e")
        env=$OPTARG
		case "$env" in
		  "Development")
			suffix="_dev"
			;;
		  "Production")
			suffix=""
			;;
		  *)
			echo "-e requires either 'Production' or 'Development' as parameter"
			exit 1
			;;
		esac
        ;;
      "?")
        echo "Unknown option $OPTARG"
        ;;
      ":")
        echo "No argument value for option $OPTARG"
        ;;
      *)
        echo "Unknown error while processing options"
        ;;
    esac
  done
if ["$env" -eq ""]
then
	echo "Parameter --env must be given"
	exit 1
fi
echo Deploying to $env
rm -R -f /home/mailwitch/pnauw$suffix #remove old
git clone https://github.com/chris68/pnauw /home/mailwitch/pnauw$suffix
# psql postgres #create the database (see migration)
# psql postgres #CREATE DATABASE pnauw_dev WITH TEMPLATE pnauw; (for Development test)
composer.phar create-project -d /home/mailwitch/pnauw$suffix 
/home/mailwitch/pnauw$suffix/init --env=$env
/home/mailwitch/pnauw$suffix/yii migrate
sudo rm -R /opt/mailwitch/www/pnauw$suffix
sudo cp -R /home/mailwitch/pnauw$suffix /opt/mailwitch/www/.
sudo rm -R /opt/mailwitch/www/pnauw$suffix/.git
sudo chown -R www-data:mailwitch /opt/mailwitch/www/pnauw$suffix
# rm -R -f /home/mailwitch/pnauw$suffix #remove again.

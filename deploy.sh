#!/bin/bash
env=""
stage="yes"
migrate="yes"
branch="master"
while getopts "b:m:s:e:" optname
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
      "b")
        branch=$OPTARG
        ;;
      "s")
        stage=$OPTARG
		case "$stage" in
		  "yes")
			;;
		  "no")
			;;
		  *)
			echo "-s (stage) requires either 'yes' or 'no' as parameter"
			exit 1
			;;
		esac
        ;;
      "m")
        migrate=$OPTARG
		case "$migrate" in
		  "yes")
			;;
		  "no")
			;;
		  *)
			echo "-m (migrate) requires either 'yes' or 'no' as parameter"
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
if [ "$env" == "" ]; then
	echo "Parameter -e (environment) must be given"
	exit 1
fi
echo Deploying to $env
rm -R -f /home/mailwitch/pnauw$suffix #remove old
git clone https://github.com/chris68/pnauw /home/mailwitch/pnauw$suffix
{ cd /home/mailwitch/pnauw$suffix; git checkout $branch; }
# psql postgres #create the database (see migration)
# psql postgres #CREATE DATABASE pnauw_dev WITH TEMPLATE pnauw; (for Development test)
sudo -H composer self-update
composer create-project -d /home/mailwitch/pnauw$suffix 

/home/mailwitch/pnauw$suffix/init --env=$env
if [ "$migrate" == "yes" ]; then
/home/mailwitch/pnauw$suffix/yii migrate
fi
if [ "$stage" == "yes" ]; then
	sudo rm -R /var/opt/mailwitch/www/pnauw$suffix
	sudo cp -R /home/mailwitch/pnauw$suffix /var/opt/mailwitch/www/.
	sudo rm -R /var/opt/mailwitch/www/pnauw$suffix/.git
	sudo chown -R www-data:mailwitch /var/opt/mailwitch/www/pnauw$suffix
fi
# rm -R -f /home/mailwitch/pnauw$suffix #remove again.

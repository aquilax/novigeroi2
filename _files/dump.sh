#!/bin/bash
mysqldump -d --add-drop-table --compatible=no_table_options --compact -u adsms -p ng2 > ./schema.sql
mysqldump -t --compact -u adsms -p ng2 > ./data.sql

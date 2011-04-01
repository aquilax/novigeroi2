#!/bin/bash
mysqldump -d --compact -u adsms -p ng2 > ./schema.sql
mysqldump -t -u adsms -p ng2 > ./data.sql

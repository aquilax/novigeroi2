#!/bin/bash
mysqldump -d --compact -u adsms -p ng2 > ./dump.sql
mysqldump -t -u adsms -p ng2 > ./data.sql

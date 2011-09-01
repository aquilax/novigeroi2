BUILD_DIR = ./build
TEMPLATES_DIR = ./_files/templates/files
TEMPLATES_FILE = ./assets/js/templates.js

DB_NAME = ng2
DB_USER = adsms
DB_SCHEMA_FILE = ./sql/mysql_schema.sql
DB_DATA_FILE = ./sql/mysql_data.sql

all: clean build_js
	
build_js: js_templates
	
js_templates:
	cat ./_files/templates/pre_templates.js > $(TEMPLATES_FILE)
	php ./tools/templates.php $(TEMPLATES_DIR) >> $(TEMPLATES_FILE)
	cat ./_files/templates/post_templates.js >> $(TEMPLATES_FILE)
	
dump_db: dump_schema dump_data
	
dump_schema:
	mysqldump -d --add-drop-table --compatible=no_table_options --compact -u $(DB_USER) -p $(DB_NAME) > $(DB_SCHEMA_FILE)

dump_data:
	mysqldump -t --compact -u $(DB_USER) -p $(DB_NAME) > $(DB_DATA_FILE)

clean:
	rm -rf $(BUILD_DIR)
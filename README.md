### Xml parser

usage

1. `docker-compose up -d`
2. `docker exec -it xmlparser bash`
3. `run command php index.php  app:parse-xml ./data/coffee_feed.xml item {sheet_id} {path_to_google_api_json_config_keys}`

`{sheet_id}` - public google sheet id
`{path_to_google_api_json_config_keys}` - https://developers.google.com/workspace/guides/create-project

run tests

`./vendor/phpunit/phpunit/phpunit ./tests/`
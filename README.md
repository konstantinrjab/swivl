```shell script
docker run --rm --interactive --tty --volume ${PWD}:/app composer install --ignore-platform-reqs --no-scripts

docker exec -it php php bin/console doctrine:migrations:migrate
```

The second part of this task is located at `part_two` folder

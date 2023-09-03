<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/test.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/test.yml/badge.svg" alt="Test Status">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/deploy.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/deploy.yml/badge.svg" alt="Deploy Status">
</a>
<br>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/tests.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/coverage.svg" alt="Code Coverage">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-code.svg" alt="Code Quality">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-architecture.svg" alt="Code Architecture">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-complexity.svg" alt="Code Complexity">
</a>
<a href="https://github.com/damianchojnacki/fleet-tracker-api/actions/workflows/insights.yml">
<img src="https://github.com/damianchojnacki/fleet-tracker-api/raw/badges/main/insights-style.svg" alt="Code Style">
</a>
</p>

## About Fleet Tracker API

## Setup

Use the following commands to setup the project:

```shell
chmod +x setup.sh
./setup.sh
```

Optionally you can follow the official [Laravel installation guide](https://laravel.com/docs/10.x/installation).

By default, database use temporary filesystem (that wipes up data every reboot) to speed up the development. 
To use persistence database, you can must comment the following lines in the end of `docker-compose.yml` file:

```yaml
driver_opts:
    o: bind
    type: none
    device: '/dev/shm'
```

## Usage

Run the following command to start the development server and other services such as database, redis etc.:

```shell
sail up -d
```

To stop the development server and other services, run the following command:

```shell
sail down
```

or to stop the development server, run the following command:

```shell
sail stop
```

To start the frontend development server run the following command:

```shell
sail npm run dev
```

Please refer to official Laravel documentation for more information about [Sail](https://laravel.com/docs/10.x/sail).

### Generating documentation

Documentation is generated using [phpDocumentor](https://www.phpdoc.org/). To generate documentation, run the following command:

```shell
./generate_docs.sh
```

## License

The TalkTango is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

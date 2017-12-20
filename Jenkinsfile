#!/usr/bin/env groovy

pipeline {

    agent {
        docker {
            image 'propertywindow/php'
            args '-u root'
        }
    }

    stages {
        stage('Construction: Build') {
            steps {
                echo 'Building...'
                sh 'composer install --prefer-source --no-interaction --dev'
            }
        }
        stage('Construction: Test') {
            steps {
                echo 'Testing...'
                sh 'vendor/bin/phpcs --standard=PSR2 src/ tests/'
                sh 'vendor/bin/phpunit'
            }
        }
        stage('Deploying: Deploy') {
            steps {
                echo 'Deploying...'
                sh 'rm -rf ./phpunit.xml.dist'
                sh 'rm -rf ./README.md'
                sh 'rm -rf ./docker-compose.yml'
                sh 'rm -rf ./.gitignore'
                sh 'rm -rf ./tests'
                sshagent(credentials:['52488a7e-586a-4087-a6fc-4654e5420403']) {
                    sh 'ssh -o StrictHostKeyChecking=no -l root propertywindow.nl rm -rf /var/www/engine.propertywindow.nl/html/*'
                    sh 'scp -r ./ root@propertywindow.nl:/var/www/engine.propertywindow.nl/html/'
                }
            }
        }
        stage('Deploying: Database') {
            steps {
                echo 'Migrations...'
                sshagent(credentials:['52488a7e-586a-4087-a6fc-4654e5420403']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no -l root propertywindow.nl 'cd /var/www/engine.propertywindow.nl/html
                        export SYMFONY_ENV=dev
                        php app/console cache:clear --env=dev --no-debug --no-warmup
                        php app/console cache:warmup --env=dev
                        php app/console doctrine:schema:drop --force
                        php app/console doctrine:schema:update --force
                        php app/console doctrine:fixtures:load'
                     '''
                }
            }
        }
        stage('Deploying: Cache') {
                    steps {
                        echo 'Clearing...'
                        sshagent(credentials:['52488a7e-586a-4087-a6fc-4654e5420403']) {
                            sh '''
                                ssh -o StrictHostKeyChecking=no -l root propertywindow.nl 'cd /var/www/engine.propertywindow.nl/html
                                export SYMFONY_ENV=prod
                                php app/console cache:clear --env=prod --no-debug --no-warmup
                                php app/console cache:warmup --env=prod'
                             '''
                        }
                    }
                }
    }
}
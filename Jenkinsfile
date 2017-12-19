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
                sshagent(credentials:['52488a7e-586a-4087-a6fc-4654e5420403']) {
                    sh 'ssh -o StrictHostKeyChecking=no -l root propertywindow.nl rm -rf /var/www/engine.propertywindow.nl/html/*'
                    sh 'scp -r ./ root@propertywindow.nl:/var/www/engine.propertywindow.nl/html/'
                }
            }
        }
        stage('Deploying: Finish') {
            steps {
                echo 'Finishing...'
                sshagent(credentials:['52488a7e-586a-4087-a6fc-4654e5420403']) {
                    sh 'ssh -o StrictHostKeyChecking=no -l root propertywindow.nl cd /var/www/engine.propertywindow.nl/html'
                    sh 'export SYMFONY_ENV=prod'
                    sh 'composer install --optimize-autoloader --no-dev'
                    sh 'php app/console cache:clear --env=prod --no-debug --no-warmup'
                    sh 'php app/console cache:warmup --env=prod'
                    sh 'php app/console doctrine:schema:drop --force'
                    sh 'php app/console doctrine:schema:update --force'
                    sh 'php app/console doctrine:fixtures:load'
                }
            }
        }
    }
}
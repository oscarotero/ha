<?php

namespace Deployer;

require 'recipe/common.php';

set('ssh_type', 'native');
set('keep_releases', 3);
set('default_stage', 'prod');
set('repository', 'git@github.com:oscarotero/historia-arte.git');
set('shared_files', ['.env']);
set('shared_dirs', [
    'data',
    'public/_',
]);

host('v1.historia-arte.com')
    ->hostname('historia-arte.com')
    ->user('v1')
    ->forwardAgent(true)
    ->stage('v1')
    ->set('branch', 'v1')
    ->set('deploy_path', '/var/www/historia-arte.com');

host('beta.historia-arte.com')
    ->hostname('historia-arte.com')
    ->user('beta')
    ->forwardAgent(true)
    ->stage('develop')
    ->set('branch', 'develop')
    ->set('deploy_path', '/var/www/beta.historia-arte.com');

host('historia-arte.com')
    ->hostname('historia-arte.com')
    ->user('historia-arte')
    ->forwardAgent(true)
    ->stage('prod')
    ->set('branch', 'master')
    ->set('deploy_path', '/var/www/historia-arte.com');

task('deploy:assets', function () {
    runLocally('node node_modules/.bin/gulp');

    $uploads = [
        'public/img',
        'public/css',
        'public/fonts',
        'public/js',
        'public/sw.js'
    ];

    foreach ($uploads as $dir) {
        writeln('<info>Uploading</info> '.$dir);
        upload($dir, '{{release_path}}/public');
    }
});

task('deploy:migrate', '
    php vendor/bin/phinx migrate;
    php vendor/bin/robo cache;
')->onStage('prod');

task('deploy:sitemap', 'php vendor/bin/robo sitemap');

task('deploy:finish', function () {
    $hash = substr(sha1(uniqid()), 0, 16);
    runLocally("ssh root@historia-arte.com \"service php7.2-fpm restart && sed -i 's/NO_BUILD_ID/{$hash}/' /var/www/historia-arte.com/current/public/index.php\"");
});

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:assets',
    'deploy:migrate',
    'deploy:sitemap',
    'deploy:symlink',
    'deploy:finish',
    'cleanup',
])->desc('Deploy the project');

after('deploy', 'success');

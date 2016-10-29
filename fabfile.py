from __future__ import with_statement
from fabric.api import run, local, cd, env, task
import ConfigParser
import os

# Read the configuration.
config_file = 'fabfile_hosts.cfg'
if os.path.isfile(config_file):
    print("Reading configuration from the file.")
    config = ConfigParser.ConfigParser()
    config.read(config_file)
    connection_string = config.get('Websupport', 'connection_string')
    env.hosts = [connection_string]
else:
    print("Getting configuration from the environment.")
    env.hosts = os.environ["WEBSUPPORT_CONNECTION_STRING"]


@task()
def deploy_stage():
    local("git push")
    branch = local("git rev-parse --abbrev-ref HEAD", True)
    print("We are on branch '{b}'.".format(b=branch))
    code_dir = 'davidlukac.com/sub/stage-registry/'
    with cd(code_dir):
        run("git pull")
        run("git checkout {b}".format(b=branch))
        run("composer install --no-dev --no-progress --no-suggest --optimize-autoloader --no-interaction")

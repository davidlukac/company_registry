[![Codeship Status for davidlukac/company_registry](https://codeship.com/projects/c16bda90-7f94-0134-6eb7-0295c16491cd/status?branch=master)](https://codeship.com/projects/181968)
[![Build Status](https://travis-ci.org/davidlukac/company_registry.svg?branch=master)](https://travis-ci.org/davidlukac/company_registry)
[![Dependency Status](https://www.versioneye.com/user/projects/5813e4103130eb0484521319/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/5813e4103130eb0484521319)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/fc44dd57328b48efa96ebde6d21cae73)](https://www.codacy.com/app/david-lukac/company_registry?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=davidlukac/company_registry&amp;utm_campaign=Badge_Grade)
[![Code Climate](https://codeclimate.com/github/davidlukac/company_registry/badges/gpa.svg)](https://codeclimate.com/github/davidlukac/company_registry)
[![Test Coverage](https://codeclimate.com/github/davidlukac/company_registry/badges/coverage.svg)](https://codeclimate.com/github/davidlukac/company_registry/coverage)


# Company Registry API
The unofficial API for Slovak Company registries (http://orsr.sk and 
http://www.zrsr.sk).


## Deployments

Deployments are handled using [Fabric](http://docs.fabfile.org/).


### Installation

Standard installation using Pip:

```
pip install -r requirements.txt
```


### Tasks

Current deployment tasks are:

- `deploy_stage`: Usage `fab deploy_stage`. Task will push and deploy current branch to the staging environment.


#### Deployment configuration

Deployment endpoints (hosts) are configured either via configuration file `fabfile_hosts.cfg` or via environment
variables.

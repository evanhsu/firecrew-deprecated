# Ansible Role: NVM

[![Build
Status](http://img.shields.io/travis/pablocrivella/ansible-role-nvm.svg?style=flat)](http://travis-ci.org/pablocrivella/ansible-role-nvm)
[![Ansible
Galaxy](http://img.shields.io/badge/galaxy-pablocrivella.nvm-660198.svg?style=flat)](https://galaxy.ansible.com/list#/roles/3745)

Role to install nvm and multiple nodejs versions.

## Requirements

Tested with Ansible 2.0.0.2.

## Role Variables

```yaml
---
# This could be set to 'user' to support user installs.
nvm_env: system

nvm_version: v0.31.6

# This sets the nvm global nodejs version.
nvm_default_node_version: stable

# List of nodejs versions to install.
nvm_node_versions:
  - stable

# List of default packages to install on each nodejs version.
nvm_global_packages: []

# List of users to install nvm and nodejs versions to.
# Ignored if nvm_env is set to 'system'
nvm_users: []
```

## Dependencies

- ANXS.git

## Example Playbook

```yaml
- hosts: js
  roles:
    - pablocrivella.nvm
```

For a more detailed example check this [Playbook](https://github.com/pablocrivella/apps-forge/blob/master/provisioning/js.yml).

## License

MIT

## Author Information

Pablo Crivella.

## Contributors

- [David Farrington](https://github.com/farridav)
- [Lorenz Bischof](https://github.com/Lorenzbi)

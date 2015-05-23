from os.path import abspath, dirname, join

from fabric.api import abort, env, hide, local, settings, task
from fabric.contrib.console import confirm

from .utils import git, ui


env.website_root = abspath(dirname(dirname(__file__)))

@task
def feature(branch_name=None):
    '''Create a new feature branch.'''
    if branch_name:
        git.new_branch(branch_name)
    else:
        print ui.error('No branch name given. Usage: fab feature:<branch_name>')


@task
def update():
    '''Rebase the current feature branch onto the latest version of upstream.'''
    print ui.info('Updating your local branch...')
    git.pull()
    print ui.info('Clearing old files...')
    local('git clean -xf *.css')


@task
def authors():
    '''Update the AUTHORS file.'''
    authors_path = join(env.website_root, 'AUTHORS')
    with hide('running'):
        local('git log --format="%%aN <%%aE>" | sort -u > %s' % authors_path)
        if local('git diff --name-only %s' % authors_path, capture=True):
            print ui.info('Automatically updating the authors file...')
            local('git commit -m "Update AUTHORS." %s' % authors_path)
        else:
            print ui.success('No change to AUTHORS.')


@task
def submit(remote='origin', skip_tests=False):
    '''Push the current feature branch and create/update pull request.'''
    first_submission = not git.remote_branch_exists(remote=remote)
    git.pull()
    authors()
    git.push()

    if not first_submission:
        print ui.success('Pull request sucessfully updated.')
    elif git.hub_installed():
        current_branch = git.current_branch()
        local('hub pull-request -b bmun:master -h %s -f' % current_branch)
        print ui.success('Pull request successfully issued.')
    else:
        print ui.success('Branch successfully pushed. Go to GitHub to issue a pull request.')


@task
def finish(branch_name=None, remote='origin'):
    '''Delete the current feature branch.'''
    prompt = ui.warning('This will delete your local and remote topic branches. '
                        'Make sure your pull request has been merged or closed. '
                        'Are you sure you want to finish this branch?')
    if not confirm(prompt):
        abort('Branch deletion canceled.')

    print ui.success('Branch %s successfully cleaned up.' % git.cleanup(branch_name,
                                                                   remote))

try:
    from deploy import deploy, restart
except ImportError:
    pass

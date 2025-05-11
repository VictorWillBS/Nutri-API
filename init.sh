    umask 002
    sudo kill  $(sudo lsof -t -i:80)
    ./vendor/bin/sail up -d
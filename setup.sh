#!/bin/sh

usage(){
    echo "Usage: $0 [Options] [targetfiles]"
    echo "Options:"
    echo "  -g  process about git"
    echo "  -p  process about directory permission"
    echo "  -c  process about code"
}

proc_git(){
    git fetch > /dev/null 2>&1
    git checkout deploy > /dev/null 2>&1
    git reset --hard origin/deploy > /dev/null 2>&1
    echo "Reseted modification after the latest commit and updated files by using git"
}

proc_permission(){
    chmod -R 775 storage/ > /dev/null
    chmod -R 775 bootstrap/cache/ > /dev/null
    echo "Changed directory permission to enable Laravel to access them"
}

proc_code(){
    if [ $# -eq 0 ]
    then
        echo "(error) Please specify target static filepaths as arguments"
    else
        python setup_code.py $@
        echo "Added query strings to static file calls in the views (Use git diff to check modification)"
    fi
}

while [ $# -gt 0 ]
do
    case "$1" in
        -*)
            if [[ "$1" =~ 'h' ]]; then
                usage
                exit 1
            fi
            if [[ "$1" =~ 'g' ]]; then
                flg_git=1
            fi
            if [[ "$1" =~ 'p' ]]; then
                flg_perm=1
            fi
            if [[ "$1" =~ 'c' ]]; then
                flg_code=1
            fi
            shift 1
            ;;
        *)
            param+=( "$1" )
            shift 1
            ;;
    esac
done

if [ $flg_git ]; then
    flg_any=1
    proc_git
fi

if [ $flg_perm ]; then
    flg_any=1
    proc_permission
fi

if [ $flg_code ]; then
    flg_any=1
    proc_code ${param[@]}
fi

if [ ! $flg_any ]; then
    usage
fi
echo -- all done

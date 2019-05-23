#!/bin/sh

proc_git(){
    # TODO
    echo "Reseted modification after the latest commit and updated files by using git"
}

proc_permission(){
    # TODO
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
    proc_git
fi

if [ $flg_perm ]; then
    proc_permission
fi

if [ $flg_code ]; then
    proc_code ${param[@]}
fi

echo -- all done

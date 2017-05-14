#!/bin/bash

# works with a file called VERSION in the current directory,
# the contents of which should be a semantic version number
# such as "1.2.3"

# this script will display the current version, automatically
# suggest a "minor" version update, and ask for input to use
# the suggestion, or a newly entered value.

# once the new version number is determined, the script will
# pull a list of changes from git history, prepend this to
# a file called CHANGES (under the title of the new version
# number) and create a GIT tag.

if [ -f VERSION ]; then
    BASE_STRING=`cat VERSION`
    if [ "$BASE_STRING" = "" ]; then
        BASE_STRING="0.0.0"
    fi
    BASE_LIST=(`echo $BASE_STRING | tr '.' ' '`)
    V_MAJOR=${BASE_LIST[0]}
    V_MINOR=${BASE_LIST[1]}
    V_PATCH=${BASE_LIST[2]}
    echo "Current version : $BASE_STRING"
    #V_MINOR=$((V_MINOR + 1))
    V_PATCH=$((V_PATCH + 1))
    SUGGESTED_VERSION="$V_MAJOR.$V_MINOR.$V_PATCH"
    #echo git branch | grep '^* release' | sed 's/* release\///'
    BRANCH=$(git branch | grep '^*' | sed 's/* //' )
    echo $BRANCH
    BRANCH_RELEASE_VERSION=$(git branch | grep '^* release' | sed 's/* release\///' )
    echo $BRANCH_RELEASE_VERSION
    if [ "$BRANCH_RELEASE_VERSION" = "" ]; then

        read -p "Enter a version number *without v. just (1.2.3) [$SUGGESTED_VERSION]: " INPUT_STRING
        if [ "$INPUT_STRING" = "" ]; then
            INPUT_STRING=$SUGGESTED_VERSION
        fi
        git flow release start --showcommands --fetch  "$INPUT_STRING"
        echo "Will set new version to be $INPUT_STRING"
    else
        INPUT_STRING=$BRANCH_RELEASE_VERSION
        echo "Will set new version to be $INPUT_STRING"
        echo $INPUT_STRING > VERSION
        echo "Version $INPUT_STRING:" > tmpfile
        git log --pretty=format:" - %s" "$BASE_STRING"...HEAD >> tmpfile
        echo "" >> tmpfile
        echo "" >> tmpfile
        cat CHANGES >> tmpfile
        mv tmpfile CHANGES
        git add CHANGES VERSION
        git commit -m "Version bump to $INPUT_STRING"
        #git tag -a -m "Tagging version $INPUT_STRING" "v$INPUT_STRING"
        #git push origin --tags

        git flow release finish --showcommands --fetch --push -m "Tagging version $INPUT_STRING" "$BRANCH_RELEASE_VERSION"
    fi
else
    echo "Could not find a VERSION file"
    read -p "Do you want to create a version file and start from scratch? [y]" RESPONSE
    if [ "$RESPONSE" = "" ]; then RESPONSE="y"; fi
    if [ "$RESPONSE" = "Y" ]; then RESPONSE="y"; fi
    if [ "$RESPONSE" = "Yes" ]; then RESPONSE="y"; fi
    if [ "$RESPONSE" = "yes" ]; then RESPONSE="y"; fi
    if [ "$RESPONSE" = "YES" ]; then RESPONSE="y"; fi
    if [ "$RESPONSE" = "y" ]; then
        INPUT_STRING="0.1.0"
        git flow release start --fetch --showcommands "$INPUT_STRING"
        echo $INPUT_STRING > VERSION
        echo "Version $INPUT_STRING:" > tmpfile
        git log --pretty=format:" - %s" >> tmpfile
        echo "" >> tmpfile
        echo "" >> tmpfile
        #cat CHANGES >> tmpfile
        mv tmpfile CHANGES
        git add VERSION CHANGES
        git commit -m "Added VERSION and CHANGES files, Version bump to v$INPUT_STRING"
        #git tag -a -m "Tagging version $INPUT_STRING" "v$INPUT_STRING"
        #git push origin --tags
    fi

fi

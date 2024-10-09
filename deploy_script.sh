#!/bin/bash

# Exit on error
set -e

# Set Firebase hosting targets
firebase target:apply hosting kirai1 kirai1
firebase target:apply hosting kirai2 kirai2

# Deploy to Firebase Hosting
firebase deploy --only hosting:kirai1
firebase deploy --only hosting:kirai2


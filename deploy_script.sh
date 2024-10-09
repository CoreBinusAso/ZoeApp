#!/bin/bash

# Exit on error
set -e

# Set Firebase hosting targets
firebase target:apply hosting site1 kirai1
firebase target:apply hosting site2 kirai2

# Deploy to Firebase Hosting
firebase deploy --only hosting:site1
firebase deploy --only hosting:site2


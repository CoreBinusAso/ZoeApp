#!/bin/bash

# Exit on error
set -e

# Set Firebase hosting targets
echo "Setting up Firebase hosting targets..."
if ! firebase target:apply hosting site1 kirai1; then
    echo "Failed to apply hosting target for site1"
    exit 1
fi

if ! firebase target:apply hosting site2 kirai2; then
    echo "Failed to apply hosting target for site2"
    exit 1
fi

# Deploy to Firebase Hosting
echo "Deploying to Firebase Hosting..."
if ! firebase deploy --only hosting:site1; then
    echo "Failed to deploy site1"
    exit 1
fi

if ! firebase deploy --only hosting:site2; then
    echo "Failed to deploy site2"
    exit 1
fi

echo "Deployment completed successfully."

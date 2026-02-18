#!/bin/bash
# FTP Deployment Script with Retry Logic
# This script retries FTP deployment up to 3 times with exponential backoff

set -e

SERVER="$1"
USERNAME="$2"
PASSWORD="$3"
SERVER_DIR="$4"
LOCAL_DIR="$5"
PROTOCOL="${6:-ftp}"
MAX_ATTEMPTS=3
RETRY_DELAY=5

echo "🚀 Starting FTP deployment..."
echo "Server: $SERVER"
echo "Protocol: $PROTOCOL"
echo "Local Dir: $LOCAL_DIR"
echo "Server Dir: $SERVER_DIR"

for attempt in $(seq 1 $MAX_ATTEMPTS); do
  echo ""
  echo "📤 Attempt $attempt of $MAX_ATTEMPTS..."
  
  if [ "$attempt" -gt 1 ]; then
    wait_time=$((RETRY_DELAY * (attempt - 1)))
    echo "⏳ Waiting ${wait_time} seconds before retry..."
    sleep $wait_time
  fi
  
  if npx @samkirkland/ftp-deploy@4.3.0 \
    --server="$SERVER" \
    --username="$USERNAME" \
    --password="$PASSWORD" \
    --server-dir="$SERVER_DIR" \
    --local-dir="$LOCAL_DIR" \
    --protocol="$PROTOCOL" \
    --dangerous-clean-slate="false" \
    --dry-run="false" \
    --exclude="**/.git*" \
    --exclude="**/.git*/**" \
    --exclude="**/README.md" \
    --exclude="**/*.md" \
    --log-level="verbose"; then
    echo "✅ Deployment successful on attempt $attempt!"
    exit 0
  else
    echo "❌ Attempt $attempt failed"
    if [ "$attempt" -eq "$MAX_ATTEMPTS" ]; then
      echo "💥 All $MAX_ATTEMPTS attempts failed"
      exit 1
    fi
  fi
done













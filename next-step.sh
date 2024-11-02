#!/bin/bash

# Stelle sicher, dass du auf dem Haupt-Branch bist (z.B. main oder master)
git checkout main

# Überprüfen, ob wir noch Commits zum Durchlaufen haben
current_commit=$(git rev-parse HEAD)
next_commit=$(git rev-list --reverse main | grep -A 1 "$current_commit" | tail -n 1)

if [ -z "$next_commit" ]; then
  echo "Keine weiteren Commits zum Auschecken. Du bist beim letzten Schritt."
else
  # Zum nächsten Commit wechseln und Commit-Nachricht ausgeben
  git checkout "$next_commit"
  commit_message=$(git log -1 --pretty=format:"%s" "$next_commit")
  echo "Ausgecheckt: $next_commit - $commit_message"
fi

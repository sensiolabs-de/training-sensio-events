#!/bin/bash

# Definiere die Commit-ID des ersten Schritts
FIRST_COMMIT="defa9b2885df7bac7045e5f27399497c5249db0c"

# Prüfen, ob der Commit-Hash gesetzt wurde
if [ -z "$FIRST_COMMIT" ]; then
  echo "Bitte setze den Commit-Hash für den ersten Schritt in diesem Skript."
  exit 1
fi

# Zum definierten ersten Commit springen
git checkout "$FIRST_COMMIT"
echo "Zum ersten Schritt gewechselt: $FIRST_COMMIT"

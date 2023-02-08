#!/bin/bash
set -euo pipefail
cd "$(dirname "$0")"

# This file fixes skeleton permission and setup, in case we have to restore it.
# thx tehron - really! :)

chmod 000 04_kwisatz/README2.md # he has to chmod for thyself.

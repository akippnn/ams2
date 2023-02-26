#!/bin/bash
# Script to install the Roboto fonts used for this inside a roboto-fonts folder.

mkdir -p /tmp/roboto-fonts
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fCRc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCRc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fABc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fABc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fCBc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCBc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fBxc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fBxc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fCxc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCxc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fChc4EsA.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fChc4EsA.woff2
curl -o roboto-fonts/KFOlCnqEu92Fr1MmSU5fBBc4.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fBBc4.woff2
curl -o roboto-fonts/KFOmCnqEu92Fr1Mu72xKOzY.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu72xKOzY.woff2
curl -o roboto-fonts/KFOmCnqEu92Fr1Mu5mxKOzY.woff2 https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu5mxKOzY.woff2
mkdir --parents ./ams2/assets/fonts/; mv roboto-fonts $_
mkdir -p /tmp/fontawesome
curl -L -o /tmp/fontawesome/fontawesome-free.zip https://use.fontawesome.com/releases/v6.3.0/fontawesome-free-6.3.0-web.zip
unzip /tmp/fontawesome/fontawesome-free.zip -d /tmp/fontawesome
mv /tmp/fontawesome/fontawesome-free-6.3.0-web ./ams2/assets/fontawesome
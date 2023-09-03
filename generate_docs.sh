#!/bin/bash

# Generate docs using phpDocumentor
docker run --rm -v $(pwd):/data phpdoc/phpdoc -d /data/app -t /data/storage/app/docs -s template.color=blue

sudo chown -R $USER:$USER storage/app/docs

# Fix paths
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/src="js/src="\/docs\/js/g' {} +
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/href="css/href="\/docs\/css/g' {} +
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/href="namespaces/href="\/docs\/namespaces/g' {} +
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/href="reports/href="\/docs\/reports/g' {} +
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/href="indices/href="\/docs\/indices/g' {} +
find storage/app/docs -type f -name "*.html" -exec sed -i'' -e 's/href="packages/href="\/docs\/packages/g' {} +

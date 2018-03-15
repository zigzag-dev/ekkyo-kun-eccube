BASE_DIR=$(cd $(dirname $0);pwd)

cd $BASE_DIR/plugin
tar -zcvf $BASE_DIR/ekkyo-kun.tar.gz *

cd $BASE_DIR

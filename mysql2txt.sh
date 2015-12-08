/**
 * @encoding UTF-8
 * @author shangbl bravelib@163.com
 * @datetime 2015/12/8 11:32
 * @power by PhpStorm
 * @Description
 */


mysql -uroot -p334a42c7570b834f -e "select * from xk_order_handle_0 where dateline>='`date -v -1d +%Y-%m-%d` 00:00:00' and dateline<='`date -v -1d +%Y-%m-%d` 23:59:59'" --skip-column-names cardstore|sed -e "s/[\t]/,/" > /usr/local/crontab/`date -v -1d +%Y%m%d`.txt



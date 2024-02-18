class PMS_ACCT_MODEL {
    constructor() {
        this.select = '/1_PMMS_MOLD/db_php/select/pms_account.php'
    }
    $getLogIN(callback) {
        $.ajax({
            url: this.select + '?action=pms_acctg',
            method: 'POST',
            data: {
                'pms': [
                    'account'
                ]
            }, success: (data) => {
                const userJson = JSON.parse(data)
                callback(userJson);
            }
        })
    }

    $getOperator(callback) {
        $.ajax({
            url: this.select + '?action=pms_operator',
            method: 'POST',
            data: {
                'pms': [
                    'operator_acct'
                ]
            }, success: (data) => {
                const opeJson = JSON.parse(data)
                callback(opeJson);
            }
        })
    }
}

const acct_model = new PMS_ACCT_MODEL();
export default acct_model;
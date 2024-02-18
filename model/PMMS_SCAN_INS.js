class PMMS_SCAN_INS {
    constructor() {
        this.login = '/1_PMMS_MOLD/db_php/select/pms_account.php';
    }

    $loginForm(usr, pass, callback) {
        $.ajax({
            url: this.login + '?action=toLogin',
            method: 'POST',
            data: {
                'pms': [
                    usr,
                    pass
                ]
            }, success: (data) => {
                callback(data)
            }
        })
    }

    $SignForm(emp_id, usr, pass, types, email, callback) {
        $.ajax({
            url: this.login + '?action=SignUp',
            method: 'POST',
            data: {
                'pms': [
                    emp_id,
                    usr,
                    pass,
                    types,
                    email
                ]
            }, success: (data) => {
                callback(data)
            }
        })
    }
}

const pms_in = new PMMS_SCAN_INS();
export default pms_in
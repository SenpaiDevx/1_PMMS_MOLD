import '../node_modules/jquery/dist/jquery.min.js'
import '../node_modules/htmx.org/dist/htmx.min.js'
import pms_in from '../model/PMMS_SCAN_INS.js'
import pms_acctg from '../control/PMMS_JOB_REG/PMMS_ACCT.js'

class PMMS_ACCT_VIEW {
    constructor() {
        this.$signUp()
    }

    $signUp() {
        $('#back').on('click', (events) => {
            document.location.reload(true)
        })
        $('#toSign').on('click', (events) => {
            $('#swap_login').css({
                "display": "none"
            })
            $('#swap_sign').removeAttr('style')
        })

        $('#toLogin').on('click', (events) => {
            events.preventDefault()
            pms_in.$loginForm($('#pms_usr').val(), $('#pms_pass').val(), (logs) => {
                let $var_msg = $('#msg')
                $var_msg.append(logs)
                $var_msg.find('div').fadeOut({
                    duration: 3000,
                    complete: function () {
                        $var_msg.empty();
                    }, done: () => {
                        let isDone = $var_msg.find('div').hasClass('alert-success')
                        if (isDone) {
                            $('#swap_login').css({
                                "display": "none"
                            })
                            $('#loginTable').removeAttr('style')
                            $('#logOperator').removeAttr('style')
                            $(document).find('br').remove()
                        } else {
                            document.location.reload(true)
                        }
                    }
                })
            })
        })

        $('#onSign').on('click', (events) => {
            events.preventDefault()
            pms_in.$SignForm(
                $('#sign_id').val(),
                $('#sign_username').val(),
                $('#sign_pass').val(),
                $('#pms_type').find(':selected').text(),
                $('#sign_email').val()
                , (html) => {
                    let $signVars = $('#sign_msg')
                    $signVars.append(html)
                    $signVars.find('div').fadeOut({
                        duration: 3000,
                        complete: function () {
                            document.location.reload(true)
                            $signVars.empty()
                        }, done: () => {
                            document.location.reload(true)
                        }
                    })
                })
        })

        $('#onLogout').on('click', () => document.location.reload(true))
    }
}

const acctg = new PMMS_ACCT_VIEW()
export default acctg;
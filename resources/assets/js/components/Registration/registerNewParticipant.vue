<template>
    <div>

        <vue-snotify></vue-snotify>


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">{{choosen_lap}}</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    const MODAL_WIDTH = 656
    import Snotify, { SnotifyPosition } from 'vue-snotify'
    import 'vue-snotify/styles/material.css'
    /*const options = {
        toast: {
            position: SnotifyPosition.rightTop
        }
    }*/
    Vue.use(Snotify)

    import VModal from 'vue-js-modal'

    Vue.use(VModal)

    export default {

        props:['event'],
        data() {
            return {
                modalWidth: MODAL_WIDTH,
                client:null,
                laps:[],
                choosen_lap:null,
                current_step:null,
                steps: {
                    step_choose:null,
                    step_register:null,
                    step_getData:null,
                    step_registerSocials:null,
                },
                data:null
            }
        },
        methods : {
            startRegister(lap) {
                console.log(lap)
                this.choosen_lap = lap.title;
                $('#myModal').modal('show')

                //this.$modal.show('login', { uid: lapUid })
                this.steps.step_choose = true
                this.current_step =  'step_choose'
            },
            getLaps() {
              var self = this;
              this.client.get('api/laps', {
                  params: {
                      event:this.event
                  }
              }).then((response) => {
                  console.log(response.data)
                  self.laps = response.data.data
                  this.$snotify.success('События загружены')
              }).catch((error) => {
                  this.$snotify.error('Связь с сервером отсутствует')

              });
            }
        },
        mounted() {
            this.client = axios.create({
                baseURL: 'http://events/',
                headers: {
                    //"content-type": "application/json",
                    "Accept": "application/json",
                    //'Authorization': 'Bearer ' + this.bearer
                }
            });
            this.getLaps();
            console.log('mounted')
        },
        created () {
            this.modalWidth = window.innerWidth < MODAL_WIDTH
                ? MODAL_WIDTH / 2
                : MODAL_WIDTH
        }

    }

</script>

<style lang="scss">
    $background_color: #404142;
    $github_color: #DBA226;
    $facebook_color: #3880FF;

    .v--modal-box {
        left:0px;
    }
    .box {
        background: white;
        overflow: hidden;
        width: 656px;
        height: 400px;
        border-radius: 2px;
        box-sizing: border-box;
        box-shadow: 0 0 40px black;
        color: #8b8c8d;
        font-size: 0;
        .box-part {
            display: inline-block;
            position: relative;
            vertical-align: center;
            box-sizing: border-box;
            height: 100%;
            width: 50%;
            &#bp-right {
                //top:100px;
                background: url("/img/logo.svg") no-repeat center center;
                border-left: 1px solid #eee;
            }
        }
        .box-messages {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
        }
        .box-error-message {
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            height: 0;
            line-height: 32px;
            padding: 0 12px;
            text-align: center;
            width: 100%;
            font-size: 11px;
            color: white;
            background: #F38181;
        }
        .partition {
            width: 100%;
            height: 100%;
            .partition-title {
                box-sizing: border-box;
                padding: 30px;
                width: 100%;
                text-align: center;
                letter-spacing: 1px;
                font-size: 20px;
                font-weight: 300;
            }
            .partition-form {
                padding: 0 20px;
                box-sizing: border-box;
            }
        }
        input[type=password],
        input[type=text] {
            display: block;
            box-sizing: border-box;
            margin-bottom: 4px;
            width: 100%;
            font-size: 12px;
            line-height: 2;
            border: 0;
            border-bottom: 1px solid #DDDEDF;
            padding: 4px 8px;
            font-family: inherit;
            transition: 0.5s all;
            outline: none;
        }
        button {
            background: white;
            border-radius: 4px;
            box-sizing: border-box;
            padding: 10px;
            letter-spacing: 1px;
            font-family: "Open Sans", sans-serif;
            font-weight: 400;
            min-width: 140px;
            margin-top: 8px;
            color: #8b8c8d;
            cursor: pointer;
            border: 1px solid #DDDEDF;
            text-transform: uppercase;
            transition: 0.1s all;
            font-size: 10px;
            outline: none;
            &:hover {
                border-color: mix(#DDDEDF, black, 90%);
                color: mix(#8b8c8d, black, 80%);
            }
        }
        .large-btn {
            width: 100%;
            background: white;
            span {
                font-weight: 600;
            }
            &:hover {
                color: white !important;
            }
        }
        .button-set {
            margin-bottom: 8px;
        }
        #register-btn,
        #signin-btn {
            margin-left: 8px;
        }
        .facebook-btn {
            border-color: $facebook_color;
            color: $facebook_color;
            &:hover {
                border-color: $facebook_color;
                background: $facebook_color;
            }
        }
        .github-btn {
            border-color: $github_color;
            color: $github_color;
            &:hover {
                border-color: $github_color;
                background: $github_color;
            }
        }
        .autocomplete-fix {
            position: absolute;
            visibility: hidden;
            overflow: hidden;
            opacity: 0;
            width: 0;
            height: 0;
            left: 0;
            top: 0;
        }
    }
    .pop-out-enter-active,
    .pop-out-leave-active {
        transition: all 0.5s;
    }
    .pop-out-enter,
    .pop-out-leave-active {
        opacity: 0;
        transform: translateY(24px);
    }
</style>
<html>
    <head>
        <meta name="_token" content="{{csrf_token()}}">
        <script src="https://live.decidir.com/static/v2.5/decidir.js"></script>
        <script src="/js/vendor.min.js"></script>
        <script>


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            
            var decidir = null
            var selectedForm = undefined
            var decidirAgro = undefined

            //Aux variables
            let decidirDevelConCS = new Decidir('https://developers.decidir.com/api/v2', false);
            decidirDevelConCS.setPublishableKey('e9cdb99fff374b5f91da4480c8dca741'); //para generar el device-fingerprint-id

            window.addEventListener("DOMContentLoaded", function() {
                   intializeExample();
               }, false);

            function FactoryDecidir(){
              this.create = function(environment, cybersource){

                var decidirInstance = null;

                if(cybersource){ // Si usa Cybersource
                  decidirInstance = decidirDevelConCS;
                }else{
                  decidirInstance = new Decidir('https://developers.decidir.com/api/v2', true);
                  decidirInstance.setPublishableKey('e9cdb99fff374b5f91da4480c8dca741');
                }

                let timeout = cybersource ? 20000 : 10000;
                decidirInstance.setTimeout(timeout);

                return decidirInstance;
              }
            }

            function intializeExample() {

              changeRequestType('card_data_form');

              let element = document.querySelectorAll('form[name=token-form');
              for (var i=0; element.length > i; i++) {
                let form = element[i];
                addEvent(form,'submit',sendForm)
              }

              addEvent(document.querySelector('input[data-decidir][name="card_number"]'), 'keyup', guessingPaymentMethod);
              addEvent(document.querySelector('input[data-decidir][name="card_number"]'), 'change', guessingPaymentMethod);

            }


            function addEvent(el, eventName, handler){
                if (el.addEventListener) {
                       el.addEventListener(eventName, handler);
                } else {
                    el.attachEvent('on' + eventName, function(){
                      handler.call(el);
                    });
                }
            };

            function withAgro(isAgro){
              decidirAgro = isAgro;

              let environment = document.querySelector('input[name="environment"]:checked').value;

              var factory = new FactoryDecidir();
              if(isAgro){
                document.querySelector('#btnGenerateToken').setAttribute('hidden', true);
                document.querySelector('#agro_set').removeAttribute('hidden');
                var $formAgro = document.querySelector('#agro_data_form');

                decidir = factory.create(environment, true);
                decidir.setUpAgro($formAgro, 184, 200); //184: d??as de pacto - 200: monto total de la operacion
              }
              else{
                document.querySelector('#agro_set').setAttribute('hidden','true');
                document.querySelector('#btnGenerateToken').removeAttribute('hidden');
              }
            }

            function sdkResponseHandler(status, response) {

              console.log('respuesta', response);

              let resultado = document.querySelector('#resultado')
              cleanHtmlElement(resultado)
              if (status != 200 && status != 201) {
                alert('Error! code: ' + status +' - response: ' + JSON.stringify(response))
              } else {
                    $.ajax({
                        url: '/test/prisma/payment',
                        method: 'POST',
                        data: {
                            token: response.id
                        },                                    
                        success: function (response) {

                        },
                        error: function (e, status) {
                            alert('Error de pago');
                        }
                    });
              }

            }

            function createHtmlListFromObject(object, parentElement) {
              let ul = document.createElement('ul')
              for (let prop in object) {
                let li = document.createElement('li')
                let spanLabel = document.createElement('span')
                let spanValue = document.createElement('span')
                spanLabel.innerText = prop + ': '
                if(typeof(object[prop]) === 'object' ) {
                  createHtmlListFromObject(object[prop],spanValue)
                } else {
                  spanValue.innerText = object[prop]
                }
                li.appendChild(spanLabel)
                li.appendChild(spanValue)
                ul.appendChild(li)
              }
              parentElement.appendChild(ul)
            }

            function cleanHtmlElement(element) {
              element.innerText = ''

              /*for (var i=0; children.length > i; i++) {
                let x = children[i];
                element.removeChild(x)
              }*/
            }




            function sendForm(event){
                event.preventDefault();

                var $form = document.querySelector('#'+selectedForm);
                
                let environment = document.querySelector('input[name="environment"]:checked').value;
                let useCybersource = document.querySelector('#fraud_prevention').checked;

                if(decidirAgro !== true){
                  var factory = new FactoryDecidir(); //Agro usa configuracion local por defecto.
                  decidir = factory.create(environment, useCybersource);
                }

                console.log('Decidir.createToken()');
                decidir.createToken($form, sdkResponseHandler);

                return false;
            };

            function guessingPaymentMethod() {

              var cardNumber = document.querySelector('input[data-decidir][name="card_number"]').value;

              var bin = decidir.getBin(cardNumber);

              var issuedInput = document.querySelector('input[name="issued"]');

              issuedInput.value = decidir.cardType(cardNumber);

              console.log('bin', bin);
            }


            function changeRequestType(value) {
              selectedForm = value
              let  containers = document.querySelectorAll('form')
              for (var i=0; containers.length > i; i++) {
                let e = containers[i];
                e.setAttribute('hidden','true')
              }
              form = document.querySelector('#'+value)
              form.removeAttribute('hidden')

            }

        </script>
    <head>
    <body>

    <div style="display: inline-block;width: 50%;">
        <ul>
            <li>
                    <label for="email">Email</label>
                    <input name="email" value="test_user_19653727@testuser.com" type="email" placeholder="your email"/>
            </li>
            <li>
                <input type="radio" name="request_type" value="card_data_form" checked onchange="changeRequestType(event.target.value);">Card data</input>
                <input type="radio"  name="request_type" value="card_token_form" onchange="changeRequestType(event.target.value);">Card token</input>
                <input type="radio"  name="request_type" value="both_form"  onchange="changeRequestType(event.target.value);">Both (validation error)</input>
                <input type="radio"  name="request_type" value="offline_token_form" onchange="changeRequestType(event.target.value);">Offline token</input>
            </li>
            <li>
                <input type="checkbox" id="fraud_prevention" checked onchange="withFraudPrevention(event.target.checked);">Use fraud prevention</input>
            </li>
            <li>
                <input type="checkbox" id="agro" onchange="withAgro(event.target.checked);">Agro</input>
            </li>
            <li>
                <input type="radio" name="environment" value="developers" checked>developers.decidir.com</input>
                <input type="radio" name="environment" value="local">localhost:9002</input>
            </li>
        </ul>
        <form action="" method="post" id="card_data_form" name="token-form" >
            <fieldset>
                        <ul>
                <li>
                    <label for="card_number">Credit card number:</label>
                    <input type="text" data-decidir="card_number" name="card_number" placeholder="XXXXXXXXXXXXXXXX" value="4507990000004905"/>
                </li>

                <li>
                    <label for="security_code">Security code:</label>
                    <input type="text"  data-decidir="security_code" placeholder="XXX" value="123" />
                </li>

                <li>
                    <label for="card_expiration_month">Expiration month:</label>
                    <input type="text"  data-decidir="card_expiration_month" placeholder="MM" value="12"/>
                </li>
                <li>
                    <label for="card_expiration_year">Expiration year:</label>
                    <input type="text"  data-decidir="card_expiration_year" placeholder="YY" value="20"/>
                </li>
                <li>
                    <label for="card_holder_name">Card holder name:</label>
                    <input type="text" data-decidir="card_holder_name" placeholder="APRO" value="EA"/>
                </li>
                <li>
                    <label for="card_holder_birthday">Card holder birthday:</label>
                    <input type="text" id="card_holder_birthday" data-decidir="card_holder_birthday" placeholder="ddMMYYYY" value="04091994"/>
                </li>
                <li>
                    <label for="card_holder_door_number">Card holder door number:</label>
                    <input type="text" id="card_holder_door_number" data-decidir="card_holder_door_number" placeholder="NUM" value="1"/>
                </li>
              <li>
                    <label for="issued">Issued:</label>
                    <input type="text" name="issued" disabled/>
                </li>
                <li>
                <label for="card_holder_doc_type">Document type:</label>
                <select data-decidir="card_holder_doc_type">
                                    <option value="dni">DNI</option>
                                </select>
                </li>
                <li>
                <label for="card_holder_doc_type">Document number:</label>
                <input type="text"data-decidir="card_holder_doc_number" placeholder="XXXXXXXXXX" value="27859328"/>
                </li>
                </ul>
                <input type="submit" value="Generate Token!" id="btnGenerateToken" />
            </fieldset>
            <fieldset id="agro_set" hidden="true">
                <ul id="agro_data_form" style="list-style: none;">
                    <li>
                        <label for="installments">Installments:</label>
                        <select data-decidir="installments"><option>Seleccionar...</option><option>1</option><option>2</option></select>
                    </li>
                    <li>
                        <label for="periodicity">Periodicity:</label>
                        <select data-decidir="periodicity"><option>Seleccionar...</option></select>
                    </li>
                    <li>
                        <label for="installment1">Installment 1:</label>
                        <input type="text" data-decidir="installment1" size="10" />
                        <label for="amount1">$</label>
                        <input type="text" data-decidir="amount1" size="8" />
                    </li>
                    <li>
                        <label for="installment2">Installment 2:</label>
                        <input type="text" data-decidir="installment2" size="10" />
                        <label for="amount2">$</label>
                        <input type="text" data-decidir="amount2" size="8" />
                    </li>
                    <li>
                        <label for="installment3">Installment 3:</label>
                        <input type="text" data-decidir="installment3" size="10" />
                        <label for="amount3">$</label>
                        <input type="text" data-decidir="amount3" size="8" />
                    </li>
                    <li>
                        <label for="installment4">Installment 4:</label>
                        <input type="text" data-decidir="installment4" size="10" />
                        <label for="amount4">$</label>
                        <input type="text" data-decidir="amount4" size="8" />
                    </li>
                    <li>
                        <label for="installment5">Installment 5:</label>
                        <input type="text" data-decidir="installment5" size="10" />
                        <label for="amount5">$</label>
                        <input type="text" data-decidir="amount5" size="8" />
                    </li>
                    <li>
                        <label for="installment6">Installment 6:</label>
                        <input type="text" data-decidir="installment6" size="10" />
                        <label for="amount6">$</label>
                        <input type="text" data-decidir="amount6" size="8" />
                    </li>

                    <li>
                        <label for="installment7">Installment 7:</label>
                        <input type="text" data-decidir="installment7" size="10" />
                        <label for="amount7">$</label>
                        <input type="text" data-decidir="amount7" size="8" />
                    </li>
                    <li>
                        <label for="installment8">Installment 8:</label>
                        <input type="text" data-decidir="installment8" size="10" />
                        <label for="amount8">$</label>
                        <input type="text" data-decidir="amount8" size="8" />
                    </li>
                    <li>
                        <label for="installment9">Installment 9:</label>
                        <input type="text" data-decidir="installment9" size="10" />
                        <label for="amount9">$</label>
                        <input type="text" data-decidir="amount9" size="8" />
                    </li>
                    <li>
                        <label for="installment10">Installment 10:</label>
                        <input type="text" data-decidir="installment10" size="10" />
                        <label for="amount10">$</label>
                        <input type="text" data-decidir="amount10" size="8" />
                    </li>
                    <li>
                        <label for="installment11">Installment 11:</label>
                        <input type="text" data-decidir="installment11" size="10" />
                        <label for="amount11">$</label>
                        <input type="text" data-decidir="amount11" size="8" />
                    </li>
                    <li>
                        <label for="installment12">Installment 12:</label>
                        <input type="text" data-decidir="installment12" size="10" />
                        <label for="amount12">$</label>
                        <input type="text" data-decidir="amount12" size="8" />
                    </li>
                    <li>
                        <label for="tokenAgro">Token Agro:</label>
                        <input type="text" name="tokenAgroMyOwnID" />
                    </li>
                </ul>
                <input type="submit" value="Pay simulation!" />
            </fieldset>
        </form>

        <form action="" method="post" id="card_token_form" name="token-form" >
                <fieldset>
                        <ul>
                            <li>
                                    <label for="token">Credit card token:</label>
                                    <input type="text"  data-decidir="token" placeholder="xxxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxx" value="ae9fc3e5-ff41-4de2-9c91-81030be1c4a6"/>
                            </li>
                            <li>
                                    <label for="security_code">Security code:</label>
                                    <input type="text"  data-decidir="security_code" placeholder="XXX" value="123" />
                            </li>
                        </ul>
                        <input type="submit" value="Generate Token!" />
                </fieldset>
        </form>

        <form action="" method="post" id="both_form" name="token-form" >
            <fieldset>
                    <ul>
              <li>
                <label for="token">Credit card token:</label>
                <input type="text"  data-decidir="token" placeholder="xxxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxx" value="70b03ded-9116-45be-91ca-27a6969ad6ac"/>
              </li>
                    <li>
                        <label for="card_number">Credit card number:</label>
                        <input type="text"  data-decidir="card_number" name="card_number" placeholder="XXXXXXXXXXXXXXXX" value="4507990000004905"/>
                    </li>

                <li>
                    <label for="security_code">Security code:</label>
                    <input type="text" data-decidir="security_code" placeholder="XXX" value="123" />
                </li>

                <li>
                    <label for="card_expiration_month">Expiration month:</label>
                    <input type="text" data-decidir="card_expiration_month" placeholder="MM" value="12"/>
                </li>
                <li>
                    <label for="card_expiration_year">Expiration year:</label>
                    <input type="text"data-decidir="card_expiration_year" placeholder="YY" value="20"/>
                </li>
                <li>
                    <label for="card_holder_name">Card holder name:</label>
                    <input type="text" data-decidir="card_holder_name" placeholder="APRO" value="EA"/>
                </li>
              <li>
                    <label for="issued">Issued:</label>
                    <input type="text" name="issued" disabled/>
                </li>
                <li>
                <label for="card_holder_doc_type">Document type:</label>
                <select  data-decidir="card_holder_doc_type">
                                    <option value="dni">DNI</option>
                                </select>
                </li>
                <li>
                <label for="card_holder_doc_type">Document number:</label>
                <input type="text" data-decidir="card_holder_doc_number" placeholder="XXXXXXXXXX" value="27859328"/>
                </li>
                </ul>
                <input type="submit" value="Generate Token!" />
            </fieldset>
        </form>

        <form action="" method="post" id="offline_token_form" name="token-form" >
            <fieldset>
                <ul>
                    <li>
                        <label for="customer_name">Customer name:</label>
                        <input type="text" data-decidir="customer_name" placeholder="APRO" value="NOMBRE APELLIDO"/>
                    </li>
                    <li>
                        <label for="customer_doc_type">Document type:</label>
                        <select  data-decidir="customer_doc_type">
                            <option value="dni">DNI</option>
                        </select>
                    </li>
                    <li>
                        <label for="customer_doc_number">Document number:</label>
                        <input type="text" data-decidir="customer_doc_number" placeholder="XXXXXXXXXX" value="27859328"/>
                    </li>
                </ul>
                <input type="submit" value="Generate Token!" />
            </fieldset>
        </form>
    </div>
    <div style="display: inline-block;width: 50%;">
        <span> Resultado</span>
        <p id="resultado"></p>
    </div>
    </body>
</html>

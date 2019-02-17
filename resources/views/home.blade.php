<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>To do list</title>
</head>
<body>
<div class="container">
    <div class="jumbotron text-center">
        <h1>To Do List</h1>
    </div>

    @if (isset($message) && !is_null($message))
        <div class="container">
            <div class="alert alert-{{ $message['type'] }} alert-dismissible fade show" role="alert">
                {{ $message['title'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Titre</th>
            <th>Type</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="4">
                <button type="button"
                        class="btn btn-success"
                        data-toggle="modal"
                        data-whatever="new"
                        data-target="#modalEvent"
                        data-url="{{ route('event.create') }}">
                    Nouvelle entrée
                </button>
            </td>
        </tr>
        </tfoot>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event['title'] }}</td>
                <td>{{ $event['type'] }}</td>
                <td>{{ $event['date'] }}</td>
                <td>
                    <a class="btn btn-primary btn-sm"
                       data-toggle="modal"
                       data-target="#modalEvent"
                       data-whatever="{{ $event['type'] }}"
                       data-content="{{ $event['id'] }}"
                       data-url="{{ route('event.edit') }}"
                       data-html="{{ route('event.get', ['type' => $event['type'], 'id' => $event['id']]) }}">
                        Modifier
                    </a>
                    <button class="btn btn-danger btn-sm delete"
                            data-whatever="{{ $event['type'] }}"
                            data-content="{{ $event['id'] }}"
                            data-target="#{{ $event['type'].$event['id'] }}"
                            data-url="{{ route('event.delete') }}"
                    >Supprimer</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Nouvelle entree -->
<div class="modal fade" id="modalEvent" tabindex="-1" role="dialog" aria-labelledby="modalEvent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form name="formEvent" id="formEvent" method="post" action="#">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEventLabel"><span></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input type="hidden" id="eventTypeH" name="eventTypeH" value="">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="eventType" id="eventTypeRappel" value="rappel">
                                <label class="form-check-label" for="eventTypeRappel">
                                    Rappel
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="eventType" id="eventTypeTache" value="tache">
                                <label class="form-check-label" for="eventTypeTache">
                                    Tache
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="eventTitle" class="col-form-label">Titre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eventTitle" name="eventTitle" placeholder="Titre de l'évenement" required="required">
                            <input type="hidden" id="eventId" name="eventId" value="">
                        </div>
                    </div>

                    <!-- Taches -->
                    <div class="form-group" id="addEventTache">
                        <label for="eventDateStart" class="col-form-label">Date de début</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="eventDateStart" name="eventDateStart">
                        </div>

                        <label for="eventDateEnd" class="col-form-label">Date de fin</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="eventDateEnd" name="eventDateEnd">
                        </div>
                    </div>

                    <!-- Rappels -->
                    <div class="form-group" id="addEventRappel">
                        <label for="eventDateDay" class="col-form-label">Journée du</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="eventDateDay" name="eventDateDay" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                    <input type="submit" class="btn btn-success" id="addEventBtn" value="Enregistrer"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    jQuery(document).ready(function ($) {
        $('button.delete').on('click', function(event){
            var button = $(event.target)
            var eventUrl = button.data('url')
            var _token = $('meta[name="csrf-token"]').attr('content')

            $.ajax({
                url: eventUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: {
                    "_method": "DELETE",
                    "_token": _token,
                    "eventType": button.data('whatever'),
                    "eventId": button.data('content'),
                },
                success: function(data){
                    $(button).closest( "tr" ).remove();
                    alert(data.title);
                }
            })
        });

        $('input[type=radio][name=eventType]').change(function(){
            showDateEvent(this.value)
        });

        $('#modalEvent').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var eventType = button.data('whatever')
            var eventUrl = button.data('url')

            loadEmpty()
            $('#formEvent').attr('action', eventUrl)

            if(eventType !== 'new') {
                $('#modalEventLabel').html('Modification de l\'évenement')
                $('#eventId').val(button.data('content'))

                $.ajax({
                    url: button.data('html'),
                    method: 'GET',
                    success: function(data){
                        console.log(data)
                        $('#eventTitle').val(data.title)
                        showDateEvent(data.type)
                        if(data.type === 'rappel') {
                            $('#eventTypeTache').attr("checked",false)
                            $('#eventTypeRappel').attr("checked",true)

                            $('#eventDateDay').val(data.dateStart)
                        } else {
                            $('#eventTypeRappel').attr("checked",false)
                            $('#eventTypeTache').attr("checked",true)

                            $('#eventDateStart').val(data.dateStart)
                            $('#eventDateEnd').val(data.dateEnd)
                        }
                    }
                })

                $('input[type=radio][name=eventType]').prop('disabled', true)
            } else {
                $('#eventTypeRappel').attr('checked',true)
                $('#eventTypeTache').attr("checked",false)
                showDateEvent('rappel')
            }
        })

        function loadEmpty() {
            $('#modalEventLabel').html('Nouvelle entrée')
            $('#eventTitle').val('')
            $('#eventId').val('')
            $('#eventTypeH').val('rappel')
            $('#eventDateStart').val('')
            $('#eventDateEnd').val('')
            $('#eventDateDay').val('')

            $('input[type=radio][name=eventType]').prop('disabled', false)
        }

        function showDateEvent(eventType){
            $('#eventTypeH').val(eventType)
            if (eventType === 'tache'){
                $('#addEventTache').show();
                $('#eventDateStart').prop('required',true);
                $('#eventDateEnd').prop('required',true);

                $('#addEventRappel').hide();
                $('#eventDateDay').prop('required',false);
            } else {
                $('#addEventTache').hide();
                $('#eventDateStart').prop('required',false);
                $('#eventDateEnd').prop('required',false);

                $('#addEventRappel').show();
                $('#eventDateDay').prop('required',true);
            }
        }
    });
</script>
</body>
</html>
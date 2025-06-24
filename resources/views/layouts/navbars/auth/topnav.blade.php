<x-lucide />
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl bg-primary " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-2 px-3 d-flex justify-content-between align-items-center">

```
    <!-- Fil d'Ariane + Titre -->
    <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb" class="me-3">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item text-sm " style="color: #E5F0F8  ;"></li>/
                <li class="breadcrumb-item text-sm  active" aria-current="page" style="color: #E5F0F8  ;"></li>
            </ol>
        </nav>
        <h5 class="mb-0" style="color: #E5F0F8; font-weight: 600;">
            {{ strtoupper(auth()->user()->firstname ?? 'Prénom') }} {{ strtoupper(auth()->user()->lastname ?? 'Nom') }}
        </h5>
        
    </div>
    


    <!-- Notifications + Déconnexion -->
    <div class="d-flex align-items-center">

        <!-- Notifications -->
        <div>
            <a class="nav-link text-white position-relative fs-4" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fa fa-bell"></i>
                <span id="notification-count" class="badge bg-danger text-white position-absolute"
                      style="top: 0px; right: -4px; font-size: 0.65rem; padding: 3px 6px; border-radius: 50%; display:none;">
                </span>
            </a>
        
            <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px">
                <ul id="notification-list" class="list-unstyled mb-0">
                    <li class="text-center text-muted">{{ __('notifications.loading') }}</li>
                </ul>
            </ul>
        </div>
        


        <!-- Déconnexion -->
        <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link  fw-bold" style="color: #F9FAFB ;">
                <i class="fa fa-sign-out-alt" style="background-color: transparent; color: #ffffff; border: none;"></i> {{ __('notifications.logout') }}
            </a>
        </form>

    </div>

</div>
```

</nav>


<!-- Include jQuery + CSRF -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
document.addEventListener("DOMContentLoaded", function () {
    loadNotifications();

    function loadNotifications() {
        fetch("{{ route('notifications.getAll') }}")
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('notification-list');
                list.innerHTML = '';

                if (data.notifications.length > 0) {
                    data.notifications.forEach(n => {
                        const li = document.createElement('li');
                        li.className = 'border-bottom pb-2 mb-2 d-flex justify-content-between align-items-start';
                        li.setAttribute('data-id', n.id);

                        li.innerHTML = `
                            <div>
                                ${n.message}
                                <br><small class="text-muted">${n.time}</small>
                            </div>
                            <span class="mark-as-read" title="Marquer comme lue" data-id="${n.id}" style="cursor: pointer;">
                                <i class="fa fa-check-circle" style="color: #0070BB; font-size: 20px;"></i>
                            </span>
                        `;

                        lucide.createIcons();
                        list.appendChild(li);
                    });
                } else {
                    list.innerHTML = '<li class="text-center text-muted">{{ __("notifications.no_notifications") }}</li>';
                }

                updateCount(data.notifications.length);
            });
    }

    function updateCount(count) {
        const counter = document.getElementById('notification-count');
        if (count > 0) {
            counter.textContent = count;
            counter.style.display = 'inline-block';
        } else {
            counter.style.display = 'none';
        }
    }

    document.addEventListener('click', function (e) {
        const target = e.target.closest('.mark-as-read');
        if (target) {
            const id = target.dataset.id;

            fetch(`/notifications/mark-as-read/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const li = document.querySelector(`li[data-id="${id}"]`);
                    if (li) li.remove();
                    updateCount(data.count);

                    const list = document.getElementById('notification-list');
                    if (list.children.length === 0) {
                        list.innerHTML = '<li class="text-center text-muted">{{ __("notifications.no_notifications") }}</li>';
                    }
                }
            });
        }
    });
});
</script>





    
<style>
    #bell-icon {
        display: inline-block;
    }

    #notification-count {
        z-index: 10;
    }

    .fa-bell {
        color:color: #ffffff !important;
        font-size: 1.2rem !important;
    }
    .position-absolute.top-0.start-100.translate-middle {
    transform: translate(-50%, -50%);
    
}



</style>




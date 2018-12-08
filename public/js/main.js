const property = $(".dlt-prop");

    if(property) {

        addEventListener('click', e => {
            e.preventDefault();

            if (e.target.className === "btn btn-danger dlt-prop")
            {
                if (confirm('Are u sure'))
                {
                    const id = e.target.getAttribute('data-propid');
                    fetch(`/admin/biens/delete/${id}`, { 
                        method: 'DELETE' 
                    }).then(res => window.location.reload());
                }
            }

        })

    }


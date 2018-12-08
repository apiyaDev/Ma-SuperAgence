const options = $('.dlt-option');

if (options)
{
    addEventListener('click', (e) => {
        e.preventDefault();
        const className = e.target.getAttribute('class');
        
        if (className === 'btn btn-danger dlt-option') {

            if (confirm('are u sure'))
            {

                const id = e.target.getAttribute('data-opid');

                fetch(`/admin/option/delete/${id}`, {
                    method: 'DELETE',
                }).then(res => window.location.reload());

            }

        }

    })
}
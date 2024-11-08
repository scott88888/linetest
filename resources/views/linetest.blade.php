<script>
     
       
     fetch('./post-endpoint', {
         headers: {
             "Content-Type": "application/json",
         },
         method: "post",
         body: JSON.stringify({
             _token: '{{ csrf_token() }}',
             moreData: "Some additional data"
         })
     }).then(function (response) {
         return response.json()
     })
         .then(function (data) {
             console.log(data);
         })
         .catch(function (error) {
             console.log('error');
         })
     </script>
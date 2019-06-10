@if(setting("3rdparty.disqus") != '' && setting("3rdparty.disqus") != 'nodisqus')
  <div class="row">
    <div class="col-lg-12">
      <div class="left_content">
        <div id="disqus_thread" class="ui segment"></div>
    			<script>
    			var disqus_config = function () {
    				this.page.url = '{{ Request::url() }}'; 
    				this.page.identifier = '{{ Request::url() }}';
    			};
    			(function() { 
      			var d = document, s = d.createElement('script');
      			s.src = 'https://{{ setting("3rdparty.disqus") }}.disqus.com/embed.js';
      			s.setAttribute('data-timestamp', +new Date());
      			(d.head || d.body).appendChild(s);
    			})();
    			</script>
    			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
      </div>
    </div>
  </div>
@endif
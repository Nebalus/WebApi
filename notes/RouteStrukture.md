api.nebalus.dev
  |- /user
  |    |- /listall   # Listed all users auf (Muss Admin sein)
  |    |- /auth
  |    |- /register
  |    |- /delete
  |    |- /get
  |    |    |- /{username}
  |    |    |    |- /linktree
  |    |    |    |    |- /create
  |    |    |    |    |- /read
  |    |    |    |    |- /update
  |    |    |    |    |- /delete
  |- /projects
  |    |- /cosmoventure
  |    |    |- /version
  |- /referrals
  |    |- /create
  |    |- /get
  |    |- /update
  |    |- /delete

ref.nebalus.dev
  |- /?????	 # Ist ein eigender Ref System

www.nebalus.dev
  |- /static      # Is not maintained by the Slim Router but by NGINX
  |    |- /js			# Default JavaScript Ordner
  |    |- /css			# Default CSS Ordner
  |    |- /img			# Default Images Ordner
  |    |- /projects
  |    |    |- /mandelbrot
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /linktree
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /comoventure
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /melody
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |- /privacy-policy		# Beinhaltet die Datenschutz Erklärung
  |- /terms-of-service
  |- /docs			# Beinhaltet die Documentation für sämtliche projecte
  |    |- /
  |- /account
  |    |- /register
  |    |- /auth
  |    |- /dashboard
  |- /linktree  # Shows the linktree from the owner "Nebalus"
  |- /blogs
  |- /u
  |    |- /{username}   # Replace the {username} by the requested user... and if requested, it will show the linktree for the user
  |- /p  # Stands for 'projects'
  |    |- /mandelbrot
  |    |- /oriri
  |    |- /cosmoventure
  |    |- /melody
  |    |   |- /commands
  |    |- /gfw
  |    |- /cybershot
  |- / 			# Ist die Standard seite

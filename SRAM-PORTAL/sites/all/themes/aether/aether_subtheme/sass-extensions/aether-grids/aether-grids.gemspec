path = "#{File.dirname(__FILE__)}/lib"
require File.join(path, 'version')

Gem::Specification.new do |gemspec|
  gemspec.name = "aether-grids"
  gemspec.version = FontIcons::VERSION # Update the VERSION.yml file to set this.
  gemspec.date = Time.now.strftime("%Y-%m-%d") # Automatically update for each build
  gemspec.description = "Aether is a versatile grid system."
  gemspec.homepage = "http://github.com/krisbulman/aether-grid"
  gemspec.authors = ["Kris Bulman"]
  gemspec.email = "kris@bulman.ca"
  gemspec.has_rdoc = false
  gemspec.require_paths = %w(lib)
  gemspec.rubygems_version = "1.4.2"
  gemspec.summary = "A Compass plugin for creating grids using the Aether grids framework."

  gemspec.add_dependency 'compass', '>= 0.11'

  gemspec.files = %w(README.markdown VERSION.yml Rakefile)
  gemspec.files += Dir.glob("lib/**/**/*")
  gemspec.files += Dir.glob("stylesheets/**/*")
end

<?php
namespace P2A\YourMembership;

use Illuminate\Support\ServiceProvider;
use P2A\YourMembership\YourMembershipClient;

class YourMembershipServiceProvider extends ServiceProvider
{

	private $packageName = 'yourmembership';
	private $packageConfigPath = __DIR__.'/config/yourmembership.php';
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
	    	$this->packageConfigPath, $this->packageName
		);

		$this->app->register(YourMembershipClient::class, function($app, $parameters) {

			$guzzleClient = new \GuzzleHttp\Client($app['config']['yourmembership']['guzzle-client']);

			return new YourMembershipClient($guzzleClient, $parameters[0], $parameters[1])
		});
	}

	public function boot()
	{
		$this->publishes([
		$this->packageConfigPath => config_path('yourmembership.php'),
		]);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(YourMembershipClient::class);
	}

}

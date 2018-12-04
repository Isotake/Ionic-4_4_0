import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, Platform } from 'ionic-angular';
import { SafariViewController } from '@ionic-native/safari-view-controller';
import { InAppBrowser } from '@ionic-native/in-app-browser';

import { Items } from '../../providers';

@IonicPage()
@Component({
  selector: 'page-item-detail',
  templateUrl: 'item-detail.html'
})
export class ItemDetailPage {
	item: any;
	base_url: string = 'https://www.apple.com';

	constructor(
		public navCtrl: NavController, 
		navParams: NavParams,
		public platform: Platform,
		private safariViewController: SafariViewController,
		private iab: InAppBrowser, 
		items: Items
		) {
			this.item = navParams.get('item') || items.defaultItem;
	}
	
	openUrl(search_words: string) {
		console.log(search_words);
		const url = this.base_url;
		if (this.platform.is('android') || this.platform.is('ios')) {
			this.safariViewController.isAvailable()
				.then((available: boolean) => {
					if (available) {
						this.safariViewController.show({
							url: url,
						})
						.subscribe(
							(result: any) => {
								if (result.event === 'opened') console.log('Opened');
								else if (result.event === 'loaded') console.log('Loaded');
								else if (result.event === 'closed') console.log('Closed');
							},
							(error: any) => console.error(error)
						);
					} else {
						this.openUrlWithInAppBrowser(url);
					}
				}
			);
		} else {
			this.openUrlWithFallbackBrowser(url);
		}
	}
	
	openUrlWithInAppBrowser(url: string) {
		const browser = this.iab.create(url, '_system');
		browser.show();
	}
	
	openUrlWithFallbackBrowser(url: string) {
		window.open(url);
	}

}

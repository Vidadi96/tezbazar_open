<div class="breadcrumb">
    <ul>
        <li>
            <a href="/" itemprop="url"><?=$this->langs->home;?></a>
            <span class="delimiter"> /</span>
        </li>
        <?php foreach(@$cats as $cat) {
          echo '<li>

                  <a href="/office/category/'.$cat->cat_id.'">'.$cat->name.'</a>
              </span>
              <span class="delimiter"> /</span>
          </li>';
        } if($last_bread){?>
        <li>
            <strong class="current-item"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?=$last_bread;?></font></font></strong>
        </li>
      <?php } ?>
    </ul>
</div>

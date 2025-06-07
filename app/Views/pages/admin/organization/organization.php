<div class="min__h__100">
  <div class="container__organization">
    <div class="row">
      <div class="col-12">
        <div class="text-center py-2">
          <div class="col-md-3 mx-auto">
            <select class="form-select select2" name="department" id="department">
              <option value="">Todos</option>
              <?php foreach($departments as $department): ?>
                <option value="<?= $department->id ?>"><?= $department->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card b-s-none pt-4">
    <div id="chart-container" class="min__h__100"></div>
  </div>
</div>
